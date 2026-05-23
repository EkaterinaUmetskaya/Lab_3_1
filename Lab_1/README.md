# 🚀 Полная инструкция: как скачать ПО и запустить готовый проект VebLab1

## 📥 1. Скачивание необходимого ПО (Windows)

### PHP 8.2+ (ОБЯЗАТЕЛЬНО!)
```
1. Иди на https://www.php.net/downloads.php
2. Скачай PHP 8.2+ → "Thread Safe" → x64
3. Распакуй в C:\php
4. Добавь C:\php в PATH:
   - Win+R → sysdm.cpl → "Переменные среды" → Path → Добавить C:\php
```

### php.ini (КРИТИЧНО для Excel!)
**C:\php\php.ini** (скопируй из `php.ini-development`):
```
memory_limit = 512M
upload_max_filesize = 50M
post_max_size = 50M
max_execution_time = 300
extension=fileinfo
extension=zip
extension=openssl
extension=pdo_sqlite
extension=sqlite3
```

**Перезапусти терминал после php.ini!**

### Composer
```
1. https://getcomposer.org/download/
2. Скачай Composer-Setup.exe → Установи
3. Проверь: composer --version
```

### Node.js 18+ LTS
```
1. https://nodejs.org/ → LTS (18.x)
2. Установи → Перезагрузи компьютер
3. Проверь: node --version && npm --version
```

## 📂 2. Открытие проекта

```
cd C:\Users\[Твоё_имя]\VSCodeProject\VebLab1
```

## 📦 3. Установка зависимостей

```bash
composer install
npm install
```

## ⚙️ 4. Настройка SQLite (.env)

**`.env`**:
```
APP_NAME=VebLab1
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

## 🗄️ 5. Подготовка базы данных

```bash
# Создай файл SQLite (если нет)
type nul > database\database.sqlite

# Очистка кэша
php artisan optimize:clear

# Миграции (миграции у тебя уже есть)
php artisan migrate:fresh
```

## 👥 6. Тестовые данные (ОБЯЗАТЕЛЬНО!)

```bash
php artisan tinker
```

**В tinker выполни:**
```php
App\Models\Teacher::create([
    'full_name' => 'Иванов Иван Иванович',
    'department' => 'Информатика', 
    'position' => 'Доцент',
    'academic_year' => '2025-2026'
]);
exit
```

## 🚀 7. Запуск проекта

### Терминал 1 (Backend):
```bash
php artisan serve
```

### Терминал 2 (Frontend):
```bash
npm run dev
```

## 🌐 8. Проверка работоспособности

**Открой:** `http://127.0.0.1:8000`

✅ **Что должно работать:**
1. **Главная** → `/upload` или логин
2. **Загрузка Excel** → `/upload` 
3. **Таблица** → `/loads` (CRUD)
4. **Экспорт** → `/study-loads/export`

## 🔧 9. Частые проблемы и решения

| ❌ Проблема | ✅ Решение |
|-------------|------------|
| `php: command not found` | Добавь C:\php в PATH |
| `pdo_sqlite not found` | Включи `extension=pdo_sqlite` в php.ini |
| `database.sqlite not found` | `type nul > database\database.sqlite` |
| `The teacher id is invalid` | Создай преподавателя через tinker |
| Excel "memory exhausted" | `memory_limit = 512M` в php.ini |
| Vue не обновляется | `npm run dev` |
| 404 на `/study-loads` | `php artisan route:clear` |

## 📱 10. Ежедневный запуск (после настройки)

```
# Терминал 1
php artisan serve

# Терминал 2  
npm run dev
```

## 🎯 11. Полная последовательность команд

```bash
# 1. Зависимости
composer install
npm install

# 2. База
type nul > database\database.sqlite
php artisan optimize:clear
php artisan migrate:fresh

# 3. Данные
php artisan tinker
# → Teacher::create([...]); exit

# 4. Запуск
php artisan serve
npm run dev  # отдельный терминал
```

## ✅ 12. Что проверить после запуска

```
http://127.0.0.1:8000
```

| Функция | Статус |
|---------|--------|
| ✅ Загрузка Excel | `/upload` |
| ✅ Таблица нагрузки | `/loads` |
| ✅ Добавить запись | Кнопка "Добавить" |
| ✅ Редактировать | Кнопка "Редактировать" |
| ✅ Удалить | Кнопка "Удалить" |
| ✅ Экспорт Excel | "Сохранить таблицу" |

***

## 🛑 Остановка проекта
**Ctrl+C** в **ОБОИХ** терминалах.

***

## 📋 Резюме установки ПО

| ПО | Ссылка | Назначение |
|----|--------|------------|
| **PHP 8.2+** | php.net | Backend |
| **Composer** | getcomposer.org | PHP пакеты |
| **Node.js 18+** | nodejs.org | Vue/Vite |
| **VS Code** | code.visualstudio.com | Редактор |

**НЕ НУЖНО:**
- MySQL/MariaDB (SQLite вместо этого)
- Apache/Nginx (php artisan serve)
- Дополнительные БД-серверы

**Время установки:** ~15 минут  
**Время запуска:** ~2 минуты

***

**Готово! Проект будет работать на `http://127.0.0.1:8000`** 🎉