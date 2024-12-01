from telegram import Update
from telegram.ext import ApplicationBuilder, CommandHandler, MessageHandler, ContextTypes, filters

# Вставьте сюда ваш токен
BOT_TOKEN = "7587552128:AAHnRyNx4c1iz7-2-0RtlWj1VuKpfk5uC38"

# Команда /start
async def start(update: Update, context: ContextTypes.DEFAULT_TYPE):
    await update.message.reply_text("Привет! Я Витёк и я буду вас развлекать!!!")

async def help_command(update: Update, context: ContextTypes.DEFAULT_TYPE):
    await update.message.reply_text("Список команд:\n/start - Начать\n/help - Помощь\n/joke - Анекдот\n/quize - Викторина\n/film - Сюрприз")

async def joke(update: Update, context: ContextTypes.DEFAULT_TYPE):
    await update.message.reply_text("– Че морда такая набитая?\n– Да один качок штангу уронил…\n– Тебе на рожу???\n– Да нет, себе на ногу…\n– Так в чем дело?\n– А я засмеялся")

async def quize(update: Update, context: ContextTypes.DEFAULT_TYPE):
    answer = "/answer"
    await update.message.reply_text(f"Как поместить 3 литра молока в сосуд на 1 литр? Ответ по команде {answer}")

async def answer(update: Update, context: ContextTypes.DEFAULT_TYPE):
    await update.message.reply_text("Приготовьте из молока сгущёнку")

async def film(update: Update, context: ContextTypes.DEFAULT_TYPE):
    film_desc = "/film_desc"
    await update.message.reply_text(
        f"Я также могу дать вам рекомендацию по фильмам. Если хотите, выберите команду {film_desc}"
    )

async def unknown_command(update: Update, context: ContextTypes.DEFAULT_TYPE):
    await update.message.reply_text(
        "Извините, я не знаю такой команды. Напишите /help, чтобы посмотреть доступные команды."
    )

async def handle_unknown_messages(update: Update, context: ContextTypes.DEFAULT_TYPE):
    await update.message.reply_text("Я не понимаю, что вы имеете в виду. Напишите /help, чтобы узнать доступные команды.")

async def handle_hello(update: Update, context: ContextTypes.DEFAULT_TYPE):
    message_text = update.message.text.lower()
    if message_text == "привет":
        await update.message.reply_text("Здравствуй! Как дела?")

async def film_desc(update: Update, context: ContextTypes.DEFAULT_TYPE):
    await update.message.reply_text("Фильм: Субстанция.Слава голливудской звезды Элизабет Спаркл осталась в прошлом, хоть она все еще ведет популярное фитнес-шоу на телевидении. Когда ее шоу собираются перезапустить с новой звездой, Элизабет решает принять уникальный препарат «Субстанция». Так на свет появляется молодая и сексуальная Сью. Однако у совершенства есть своя цена, и расплата не заставит себя долго ждать.")

if __name__ == "__main__":
    # Создаем приложение
    app = ApplicationBuilder().token(BOT_TOKEN).build()

    # Регистрируем команды
    app.add_handler(CommandHandler("start", start))
    app.add_handler(CommandHandler("help", help_command))
    app.add_handler(CommandHandler("joke", joke))
    app.add_handler(CommandHandler("quize", quize))
    app.add_handler(CommandHandler("answer", answer))
    app.add_handler(CommandHandler("film", film))
    app.add_handler(CommandHandler("film_desc", film_desc))

    app.add_handler(MessageHandler(filters.TEXT, handle_hello))
    app.add_handler(MessageHandler(filters.COMMAND, unknown_command))
    app.add_handler(MessageHandler(filters.ALL, handle_unknown_messages))

    # Запускаем бота
    print("Бот запущен!")
    app.run_polling()
