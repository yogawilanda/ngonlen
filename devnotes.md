Check your list here
php artisan route:list 


Disable verification for early use
routes\web.php
->middleware(['auth', 'verified', EnsureTeamMembership::class])

to

routes\web.php
->middleware(['auth', EnsureTeamMembership::class])
