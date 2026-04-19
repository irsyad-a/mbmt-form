# Deploy Laravel MBMT ke VPS (Ubuntu)

Dokumen ini untuk deploy aplikasi ke VPS dengan Nginx, PHP-FPM, MariaDB, dan dashboard admin yang sudah Anda buat.

## 1) Siapkan repository lokal

Pastikan perubahan terbaru sudah Anda push ke repository GitHub.

## 2) Setup awal di VPS

Masuk ke VPS:

ssh root@IP_VPS_ANDA

Install dependency server:

apt update && apt upgrade -y
apt install -y nginx mariadb-server git unzip curl software-properties-common ufw
add-apt-repository ppa:ondrej/php -y
apt update
apt install -y php8.3 php8.3-fpm php8.3-cli php8.3-common php8.3-mysql php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip php8.3-bcmath php8.3-intl php8.3-gd
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt install -y nodejs

## 3) Buat database produksi

mysql -u root -p

Di shell MariaDB:

CREATE DATABASE mbmt_form CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'mbmt_user'@'localhost' IDENTIFIED BY 'PASSWORD_DB_STRONG';
GRANT ALL PRIVILEGES ON mbmt_form.* TO 'mbmt_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

## 4) Clone project di server

mkdir -p /var/www
cd /var/www
git clone https://github.com/irsyad-a/simpen-project.git mbmt
cd /var/www/mbmt

## 5) Siapkan environment production

cp deploy/.env.production.example .env
php artisan key:generate

Edit .env dan ubah nilai berikut:

APP_URL=https://domain-anda.com
DB_PASSWORD=PASSWORD_DB_STRONG
DASHBOARD_USERNAME=admin
DASHBOARD_PASSWORD=PASSWORD_DASHBOARD_STRONG
MAIL_MAILER=smtp
MAIL_SCHEME=tls
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-char-app-password
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="MBMT LMB ITS"

Catatan Gmail:

- Aktifkan 2-Step Verification pada akun Google.
- Buat App Password (16 karakter) dan pakai nilainya di MAIL_PASSWORD.
- Jangan gunakan password login Gmail biasa di MAIL_PASSWORD.

## 6) Jalankan deploy otomatis

chmod +x scripts/vps/deploy-app.sh
APP_DIR=/var/www/mbmt ./scripts/vps/deploy-app.sh

## 7) Konfigurasi Nginx

cp deploy/nginx-mbmt.conf.example /etc/nginx/sites-available/mbmt

Edit server_name di file Nginx sesuai domain atau IP Anda.

Aktifkan site:

ln -s /etc/nginx/sites-available/mbmt /etc/nginx/sites-enabled/mbmt
nginx -t
systemctl restart nginx php8.3-fpm
systemctl enable nginx php8.3-fpm mariadb

## 8) Firewall

ufw allow OpenSSH
ufw allow 'Nginx Full'
ufw --force enable

## 9) (Opsional tapi disarankan) Jalankan queue worker

cp deploy/laravel-queue.service.example /etc/systemd/system/laravel-queue.service
systemctl daemon-reload
systemctl enable laravel-queue
systemctl start laravel-queue
systemctl status laravel-queue --no-pager

## 10) Akses aplikasi

Form publik:

https://domain-anda.com/

Dashboard admin:

https://domain-anda.com/dashboard/login

## 11) Deploy update berikutnya

cd /var/www/mbmt
APP_DIR=/var/www/mbmt ./scripts/vps/deploy-app.sh

## 12) Verifikasi email tanpa terminal (Dashboard)

Jika platform Anda tidak menyediakan terminal, gunakan dashboard admin:

1. Login ke dashboard: https://domain-anda.com/dashboard/login
2. Buka halaman Data Pendaftar.
3. Pada panel "Tes Email Tanpa Terminal", cek nilai MAIL_MAILER/MAIL_HOST/MAIL_USERNAME.
4. Isi email tujuan uji lalu klik "Kirim Email Uji".
5. Jika gagal, pesan error SMTP akan tampil di dashboard.

## 13) Verifikasi kirim email via terminal (opsional)

Setelah deploy, kirim email uji dari server:

php artisan tinker --execute="\Illuminate\Support\Facades\Mail::raw('Tes email MBMT berhasil.', function ($message) { $message->to('email-anda@contoh.com')->subject('Tes Email MBMT'); });"

Jika gagal, cek log:

tail -n 100 storage/logs/laravel.log

## 14) Aktifkan HTTPS (domain)

apt install -y certbot python3-certbot-nginx
certbot --nginx -d domain-anda.com -d www.domain-anda.com

## 15) Catatan keamanan penting

- Gunakan password dashboard yang kuat.
- Jangan pakai APP_DEBUG=true di production.
- Jangan commit file .env ke repository.
- Backup database secara rutin.
