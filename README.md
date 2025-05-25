# 🐘 Prueba Técnica Laravel + Livewire – eAgora

## 🎯 Objetivo

Desarrollar una mini-aplicación con Laravel y Livewire que consuma, visualice y filtre incidencias públicas (issues) del repositorio de Laravel Framework en GitHub.

## 📡 Endpoint a Consumir

```
https://api.github.com/repos/laravel/framework/issues
```

Este endpoint devuelve una lista de tickets con los siguientes campos:
- `id`, `number`, `title`, `state`
- `user.login`, `user.avatar_url`
- `labels[]`, `created_at`, `body`, etc.

## 🔧 Requisitos Técnicos

### Backend (Laravel)

1. **Consumo de Issues**
   - Consumir el endpoint y devolver un array limpio con:
     - `id`, `number`, `title`, `state`, `user.login`, `labels[]`, `created_at`

2. **Análisis por Estado**
   - Calcular cuántos tickets están abiertos y cuántos cerrados

3. **Top Usuarios**
   - Mostrar el top 5 de usuarios con más issues creados

4. **Tickets Recientes**
   - Filtrar issues creados en los últimos 7 días

5. **Paginación Manual**

### Frontend (Livewire)

1. **Listado de Tickets**
   - Mostrar título, autor, avatar, estado y etiquetas
   - Diseño responsive con Tailwind CSS

2. **Búsqueda en Tiempo Real**
   - Campo de búsqueda que filtra por título
   - Implementar con `wire:model`

3. **Filtro por Estado**
   - Dropdown para seleccionar `open` / `closed`

4. **Vista Detallada**
   - Al hacer clic en un ticket, mostrar:
     - `body`
     - Cantidad de comentarios
     - Enlace a GitHub

5. **Estadísticas en Tiempo Real**
   - Mostrar contadores de tickets abiertos/cerrados
   - Mostrar top usuarios
   - Mostrar tickets recientes

## 🚀 Setup del Proyecto

```bash
# Clonar el repositorio
git clone
cd eagora-challenge

# Iniciar Docker
docker compose up -d --build

# Instalar dependencias
composer install
npm install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Compilar assets
npm run dev
```

## 🧪 Tests

El proyecto debe incluir tests automatizados usando Pest:

```bash
# Ejecutar tests
./vendor/bin/pest
```

### Tests Requeridos
- Tests de API para endpoints
- Tests de componente Livewire
- Tests de integración

## 🛠️ Tecnologías a Utilizar

- Laravel 10.x
- Livewire 3.x
- Tailwind CSS
- Pest PHP
- Docker
- GitHub API

## 📝 Criterios de Evaluación

1. **Calidad del Código**
   - Clean Code
   - Patrones de diseño
   - Manejo de errores

2. **Funcionalidad**
   - Implementación completa de requisitos
   - Interactividad en tiempo real
   - Experiencia de usuario

3. **Tests**
   - Cobertura de tests
   - Calidad de las pruebas
   - Casos de uso cubiertos

## ⏱️ Tiempo Estimado

- 2 horas
- Esta prueba técnica está diseñada para evaluar habilidades en Laravel, Livewire, y desarrollo full-stack en general. Sabemos que en menos de 2h es difícil cubrir todos los casos de uso, pero nos interesa saber hasta donde llegais, y que consideráis más y menos importante para cubrir en este tiempo.*


## 📄 Entrega

1. Repositorio en GitHub
2. README con instrucciones
3. Tests implementados
4. Código documentado

---

