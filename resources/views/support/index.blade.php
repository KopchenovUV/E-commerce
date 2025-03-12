@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="animateanimated animatefadeInDown">Поддержка</h1>
        <div class="card animateanimated animatefadeIn">
            <div class="card-body">
                <div id="chat-box" class="border rounded p-3 mb-3" style="height: 400px; overflow-y: auto; background-color: #f8f9fa;">
                    @foreach ($messages as $message)
                        <div class="mb-2">
                            <strong>{{ $message->sender === 'bot' ? 'Бот' : 'Вы' }}:</strong> {{ $message->message }}
                        </div>
                    @endforeach
                </div>
                <form id="chat-form">
                    <div class="input-group">
                        <input type="text" name="message" id="user-input" class="form-control" placeholder="Введите ваш вопрос..." required>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="complaintModal" tabindex="-1" aria-labelledby="complaintModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="complaintModalLabel">Оставить жалобу</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="complaint-form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="complaint">Опишите вашу проблему:</label>
                            <textarea name="complaint" id="complaint" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" style="color: white;" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatBox = document.getElementById('chat-box');
            const chatForm = document.getElementById('chat-form');
            const userInput = document.getElementById('user-input');
            const complaintModal = new bootstrap.Modal(document.getElementById('complaintModal'));
            const complaintForm = document.getElementById('complaint-form');

            let step = 0;
            let userQuestion = '';
            let selectedCategory = '';

            chatForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                const message = userInput.value.trim();
                if (message) {
                    try {
                        const response = await fetch("{{ route('support.send') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({ message: message }),
                        });
                        const data = await response.json();
                        addMessage('пользователь', message);
                        const botResponse = await processResponse(data.response, message);
                        addMessage('бот', botResponse);
                        userInput.value = '';
                    } catch (error) {
                        console.error('Ошибка:', error);
                    }
                }
            });

            complaintForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                const complaint = document.getElementById('complaint').value.trim();
                if (complaint) {
                    try {
                        const response = await fetch("{{ route('support.complaint') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({ complaint: complaint }),
                        });
                        const data = await response.json();
                        addMessage('бот', data.message);
                        complaintModal.hide();
                        document.getElementById('complaint').value = '';
                        step = 0;
                    } catch (error) {
                        console.error('Ошибка:', error);
                    }
                }
            });

            function addMessage(sender, text) {
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('mb-2');
                messageDiv.innerHTML = `<strong>${sender === 'бот' ? 'Бот' : 'Вы'}:</strong> ${text}`;
                chatBox.appendChild(messageDiv);
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            async function processResponse(response, message) {
                const lowerMessage = message.toLowerCase();

                if (step === 0) {
                    userQuestion = lowerMessage;
                    step = 1;
                    return response;
                } else if (step === 1) {
                    if (userQuestion.includes('доставка')) {
                        if (lowerMessage.includes('срок') || lowerMessage.includes('время')) {
                            step = 2;
                            return 'Сроки доставки зависят от региона. Обычно это 2-5 дней. Укажите ваш город для точного ответа.';
                        } else if (lowerMessage.includes('стоимость') || lowerMessage.includes('цена')) {
                            step = 2;
                            return 'Стоимость доставки начинается от 300 рублей. Укажите ваш регион для точной суммы.';
                        } else {
                            step = 0;
                            complaintModal.show();
                            return 'Ваша проблема не решена, сейчас позову оператора. Хотите оставить жалобу?';
                        }
                    } else if (userQuestion.includes('оплата')) {
                        if (lowerMessage.includes('онлайн')) {
                            step = 0;
                            return 'На данный момент оплата онлайн не поддерживается, но мы работаем над этим.';
                        } else if (lowerMessage.includes('получении')) {
                            step = 2;
                            return 'Оплата при получении доступна в большинстве регионов. Укажите ваш город.';
                        } else {
                            step = 0;
                            complaintModal.show();
                            return 'Ваша проблема не решена, сейчас позову оператора. Хотите оставить жалобу?';
                        }
                    } else if (userQuestion.includes('товар')) {
                        selectedCategory = lowerMessage;
                        step = 2;
                        const res = await fetch('/support/categories/' + encodeURIComponent(lowerMessage));
                        const data = await res.json();
                        if (data.products.length > 0) {
                            const productList = data.products.map(p => p.name).join(', ');
                            return `В категории "${lowerMessage}" есть товары: ${productList}. Хотите узнать о каком-либо товаре подробнее?`;
                        } else {
                            step = 0;
                            complaintModal.show();
                            return `Категория "${lowerMessage}" не найдена. Ваша проблема не решена, сейчас позову оператора. Хотите оставить жалобу?`;
                        }
                    } else {
                        step = 0;
                        complaintModal.show();
                        return 'Ваша проблема не решена, сейчас позову оператора. Хотите оставить жалобу?';
                    }
                } else if (step === 2) {
                    if (userQuestion.includes('доставка') || userQuestion.includes('оплата')) {
                        step = 0;
                        return 'Спасибо за уточнение! Если у вас остались вопросы, задавайте их снова.';
                    } else if (userQuestion.includes('товар')) {
                        step = 3;
                        const res = await fetch('/support/product/' + encodeURIComponent(message));
                        const data = await res.json();
                        if (data.product) {
                            return `Описание товара "${message}": ${data.product.description}. Цена: ${data.product.price} руб. Хотите узнать что-то ещё или задать новый вопрос?`;
                        } else {
                            step = 0;
                            return `Товар "${message}" не найден. Задайте новый вопрос или уточните название.`;
                        }
                    }
                } else if (step === 3 && userQuestion.includes('товар')) {
                    step = 0;
                    return 'Здравствуйте! Я чат-бот поддержки TechShop. Как могу вам помочь?';
                }
            }
        });
    </script>
@endsection