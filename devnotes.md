Check your list here
php artisan route:list 


Disable verification for early use
routes\web.php
->middleware(['auth', 'verified', EnsureTeamMembership::class])

to

routes\web.php
->middleware(['auth', EnsureTeamMembership::class])


untuk routes yang butuh load time diatas 800, gunakan skeleton jika gambar tersebut butuh alt name, gunakan nama dari titlenya.
