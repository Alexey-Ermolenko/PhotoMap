# PhotoMap
## Application for searching photos from the social network VK API

## Based on docker | Nginx | PHP 7.3.7 | Postgres | SSL

### Installation

#### 1. Create a Self-Signed SSL Certificate

Install Certutil

- `sudo apt install libnss3-tools -y`

Install mkcert

- `wget https://github.com/FiloSottile/mkcert/releases/download/v1.1.2/mkcert-v1.1.2-linux-amd64`
- `mv mkcert-v1.1.2-linux-amd64 mkcert`
- `chmod +x mkcert`
- `sudo cp mkcert /usr/local/bin/`

Generate Local CA

- `mkcert -install`

Generate Local SSL Certificates

- `sudo mkcert example.com '\*.example.com' localhost 127.0.0.1 ::1`

Copy the certificate `example.com+4.pem` and key `example.com+4-key.pem` into folder `.docker/nginx` of your project.

Rename these files to `server.pem` and `server-key.pem` and give the permission `644`.

- `sudo chmod 644 server.pem`
- `sudo chmod 644 server-key.pem`

#### 2. Make .env file `cp .env.example .env`  and configure

#### 3. Run `docker-composer up -d --build`

#### 4. You can open application in your browser `https://localhost/`