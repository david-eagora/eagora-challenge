# 🐘 Laravel + Livewire Technical Challenge – eAgora

Este proyecto consiste en una mini-aplicación desarrollada con Laravel y Livewire para consumir, visualizar y filtrar incidencias públicas (issues) de un repositorio real de GitHub.

---

## 🎯 Objetivo

Evaluar habilidades backend (Laravel) y frontend (Livewire) mediante el consumo de un endpoint real con datos de incidencias. Se han de pasar los tests. El candidato es libre de añadir más tests. El candidato es libre de emplear cualquier libreria y arquitectura deseada. El tiempo máximo no debería superar las 2h.

---

## 📡 Endpoint Público

Usamos el endpoint de GitHub Issues del repositorio de Laravel:

https://api.github.com/repos/laravel/framework/issues


Este endpoint devuelve una lista de tickets (issues) con campos como:

- `id`, `number`, `title`, `state`
- `user.login`, `user.avatar_url`
- `labels[]`, `created_at`, `body`, etc.

---

## 🔧 Backend (Laravel)

### Ejercicios propuestos:

1. **Consumo de Issues**
   - Consumir el endpoint y devolver un array limpio con los siguientes campos:
     - `id`, `number`, `title`, `state`, `user.login`, `labels[]`, `created_at`

2. **Análisis por Estado**
   - Calcular cuántos tickets están abiertos y cuántos cerrados.

3. **Top Usuarios**
   - Mostrar el top 5 de usuarios con más issues creados.

4. **Tickets Recientes**
   - Filtrar issues creados en los últimos 7 días.

5. **Paginación manual (opcional)**
   - Limitar la cantidad de issues devueltos a 20 y paginar manualmente con `skip()` y `take()`.

---

## 🖥️ Frontend (Livewire)

### Funcionalidades:

1. **Listado de Tickets**
   - Muestra título, autor, avatar, estado y etiquetas.

2. **Búsqueda en Tiempo Real**
   - Campo de búsqueda que filtra por título (reactivo con `wire:model`).

3. **Filtro por Estado**
   - Dropdown para seleccionar `open` / `closed`.

4. **Ver Detalles**
   - Al hacer clic en un ticket, mostrar más detalles: `body`, cantidad de comentarios, enlace a GitHub.

5. **(Opcional) Etiquetas como chips filtrables**

---

## 🚀 Setup Rápido

```bash
git clone
cd eagora-challenge

docker compose up -d --build

composer install
cp .env.example .env
php artisan key:generate

