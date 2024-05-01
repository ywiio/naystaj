from telebot import TeleBot
from telebot import types
import mysql.connector

bot = TeleBot('7097589085:AAFvAs68ORin5PHja0pRRH7qXHbMVTiBI7U')

db = mysql.connector.connect(
    user='root', 
    password='',
    host='localhost',
    database='naystaj'
)
cursor = db.cursor()

@bot.message_handler(commands=['start'])
def start(message):
    markup = types.InlineKeyboardMarkup()
    about=types.InlineKeyboardButton('Подробнее о турах', callback_data='info_about')
    faq=types.InlineKeyboardButton('FAQ', callback_data='info_faq')
    contacts=types.InlineKeyboardButton('Контакты', callback_data='info_contacts')
    markup.add(about,faq,contacts)
    bot.send_message(message.chat.id, f'Привет! Чем я могу помочь?', parse_mode='html', reply_markup=markup)

@bot.callback_query_handler(func=lambda call: call.data.startswith('info_'))
def callback_worker(call):
    if call.data == "info_about":
        cursor.execute("SELECT id, name FROM tours")
        results = cursor.fetchall()
        markup = types.InlineKeyboardMarkup()
        for row in results:
            tour_id = row[0]
            tour_name = row[1]
            tour_button = types.InlineKeyboardButton(f'{tour_name}', callback_data=f'tours_{tour_id}')
            markup.add(tour_button)
        bot.send_message(call.message.chat.id, "Вот список доступных туров. Нажмите, чтобы узнать подробнее ", parse_mode='html', reply_markup=markup)
        
    elif call.data == "info_faq":
        markup = types.InlineKeyboardMarkup()
        ans1 = types.InlineKeyboardButton('Есть ли возможность индивидуального маршрута или персонализации экскурсии?', callback_data=f'ans_1')
        ans2 = types.InlineKeyboardButton('Какие варианты транспорта предоставляются для экскурсий?', callback_data=f'ans_2')
        ans3 = types.InlineKeyboardButton('Какие формы оплаты вы принимаете?', callback_data=f'ans_3')
        markup.add(ans1)
        markup.add(ans2)
        markup.add(ans3)
        bot.send_message(call.message.chat.id, 'Чтобы увидеть ответ, нажми на вопрос', parse_mode='html', reply_markup=markup)
        
    elif call.data == "info_contacts":
        markup = types.InlineKeyboardMarkup()
        back=types.InlineKeyboardButton('Вернуться к началу', callback_data='commands')
        markup.add(back)
        bot.send_message(call.message.chat.id, '<b>Контакт-центр:</b>\n8 (029) 555-55-55 \n8 (029) 555-55-55\n\n<b>Адрес:</b> г. Минск, ул. Немига, д.34\n\n<b>Режим работы:</b> \nпн-пт: 10:00-21:00 \nсб-вс: 11:00-22:00', parse_mode='html', reply_markup=markup)


@bot.callback_query_handler(func=lambda call: call.data.startswith('tours_'))
def handle_tour_info(call):
    tour_id = call.data.split('_')[1] 
    bot.send_message(call.message.chat.id, f"Основная инфорамция о туре:")
    cursor.execute(f"SELECT name, overview2, hero_img FROM tours WHERE id = {tour_id}")
    results = cursor.fetchall()
    for row in results:
        name = row[0]
        overview2 = row[1]
        tour_img = row[2]
        markup = types.InlineKeyboardMarkup()
        tour=types.InlineKeyboardButton('Программа тура', callback_data=f'tour_info_{tour_id}')
        back=types.InlineKeyboardButton('Вернуться к началу', callback_data='commands')
        markup.add(tour, back)
        photo = open(f'..{tour_img}', 'rb')
        bot.send_photo(call.message.chat.id, photo, caption=f'<b>{name}:</b>\n{overview2}', parse_mode='html', reply_markup=markup)
        
@bot.callback_query_handler(func=lambda call: call.data.startswith('tour_info_'))
def handle_tour_schedule(call):
    tour_id = call.data.split('_')[2] 
    cursor.execute(f"SELECT name, schedule FROM tours WHERE id = {tour_id}")
    results = cursor.fetchall()
    for row in results:
        name = row[0]
        schedule = row[1]
        markup = types.InlineKeyboardMarkup()
        back=types.InlineKeyboardButton('Вернуться к началу', callback_data='commands')
        end=types.InlineKeyboardButton('Завершить', callback_data='end')
        markup.add(back, end)
        bot.send_message(call.message.chat.id, f'<b>Расписание тура "{name}":</b>\n{schedule}', parse_mode='html', reply_markup=markup)


@bot.callback_query_handler(func=lambda call: call.data.startswith('ans_'))
def callback_worker(call):
    if call.data == "ans_1":
        markup = types.InlineKeyboardMarkup()
        commands = types.InlineKeyboardButton('Вернуться к началу', callback_data='commands')
        markup.add(commands)
        bot.send_message(call.message.chat.id, f"""Да, у нас есть возможность индивидуального маршрута или персонализации экскурсии. Мы понимаем, что каждый клиент имеет свои уникальные предпочтения и интересы, поэтому мы готовы адаптировать наши экскурсии под ваши потребности. Вы можете связаться с нами и обсудить свои пожелания с нашими менеджерами. Мы поможем вам создать индивидуальный маршрут или внести изменения в экскурсию, чтобы она полностью соответствовала вашим ожиданиям.""", 
                        parse_mode='html', reply_markup=markup)
    elif call.data == "ans_2":
        markup = types.InlineKeyboardMarkup()
        commands = types.InlineKeyboardButton('Вернуться к началу', callback_data='commands')
        markup.add(commands)
        bot.send_message(call.message.chat.id, f"""Мы предоставляем различные варианты транспорта для экскурсий. В зависимости от места и типа экскурсии, мы можем предложить следующие варианты транспорта:
                                                \n1. Автобусы: Мы организуем экскурсии на комфортабельных автобусах, которые позволяют перемещаться между достопримечательностями с удобством и безопасностью.
                                                \n2. Микроавтобусы: Для более маленьких групп или индивидуальных экскурсий мы предлагаем микроавтобусы, которые обеспечивают более гибкое и персонализированное путешествие.
                                                \n3. Такси: В некоторых случаях мы можем организовать экскурсии с использованием такси, что позволяет более гибко планировать маршрут и время поездки.
                                                \n4. Пешие экскурсии: Для некоторых экскурсий, особенно в исторических центрах городов или пешеходных зонах, мы предлагаем пешие экскурсии, чтобы вы могли насладиться близким знакомством с достопримечательностями.""", 
                                                parse_mode='html', reply_markup=markup)
    elif call.data == "ans_3":
        markup = types.InlineKeyboardMarkup()
        commands = types.InlineKeyboardButton('Список команд', callback_data='commands')
        markup.add(commands)
        bot.send_message(call.message.chat.id, f"""Мы принимаем различные формы оплаты:
                                                \n1. Наличные: Вы можете оплатить экскурсию наличными в нашем офисе или при встрече с нашим представителем.
                                                \n2. Банковские карты: Мы принимаем платежи с помощью кредитных и дебетовых карт, таких как Visa, MasterCard, American Express и других.
                                                \n3. Банковский перевод: Если вам удобнее совершить банковский перевод, мы предоставим вам необходимую информацию для осуществления платежа.""", 
                                                parse_mode='html', reply_markup=markup)

@bot.callback_query_handler(func=lambda call: call.data.startswith('commands'))
def callback_worker(call):
    markup = types.InlineKeyboardMarkup()
    about=types.InlineKeyboardButton('Подробнее о турах', callback_data='info_about')
    faq=types.InlineKeyboardButton('FAQ', callback_data='info_faq')
    contacts=types.InlineKeyboardButton('Контакты', callback_data='info_contacts')
    markup.add(about,faq,contacts)
    bot.send_message(call.message.chat.id, f'Вот список доступных команд: ', parse_mode='html', reply_markup=markup)

@bot.callback_query_handler(func=lambda call: call.data.startswith('end'))
def end_method(call):
        bot.send_message(call.message.chat.id, f'Напиши /start, чтобы начать', parse_mode='html')

if __name__ == '__main__':
    bot.polling(none_stop=True)
