# Auth Fix TODO

- [x] Fix `routes/auth.php` — move `/register/mechanic` into `guest` group
- [x] Fix `RegisteredUserController.php` — remove duplicate `is_verified_mechanic` key
- [x] Fix `routes/web.php` — remove `verified` middleware from dashboard
- [x] Fix `resources/views/dashboard.blade.php` — make it a working user dashboard without undefined variables
- [x] Test registration, login, dashboard, logout

