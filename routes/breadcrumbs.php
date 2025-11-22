<?php

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\Demande;

// Admin Dashboard
Breadcrumbs::for('admin.dashboardadmin', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboardadmin'));
});
// List Demandes
Breadcrumbs::for('listdemandes.index', function ($trail) {//title du breadcrumbs
    $trail->parent('admin.dashboardadmin');
    $trail->push('List Demandes', route('listdemandes.index'));//nom qui va afficher + route dans web.php
});
Breadcrumbs::for('division.index', function ($trail) {//title du breadcrumbs
    $trail->parent('admin.dashboardadmin');
    $trail->push('Divisions', route('division.index'));//nom qui va afficher + route dans web.php
});
Breadcrumbs::for('service.index', function ($trail) {//title du breadcrumbs
    $trail->parent('admin.dashboardadmin');
    $trail->push('Services', route('service.index'));//nom qui va afficher + route dans web.php
});

// Ajouter Utilisateur
Breadcrumbs::for('users.create', function ($trail) {
    $trail->parent('admin.dashboardadmin');
    $trail->push('Ajouter Utilisateur', route('users.create'));
});

// Liste des Utilisateurs
Breadcrumbs::for('users.index', function ($trail) {
    $trail->parent('admin.dashboardadmin');
    $trail->push('Liste des Utilisateurs', route('users.index'));
});
// Voir des Utilisateurs
Breadcrumbs::for('users.show', function ($trail, $userId) {
    $trail->parent('users.index');
    // Fetch the user object from the ID
    $user = User::find($userId);
    $trail->push($user->nomFr . ' ' . $user->prenomFr, route('users.show', $userId));

});
// Modifier des Utilisateurs
Breadcrumbs::for('users.edit', function ($trail, $userId) {
    $trail->parent('users.index');
    // Fetch the user object from the ID
    $user = User::find($userId);
    $trail->push($user->nomFr . ' ' . $user->prenomFr, route('users.edit', $userId));
});
// Ajoute Recap des Utilisateurs
Breadcrumbs::for('recapadd.edit', function ($trail, $userId) {
    $trail->parent('users.index');
    // Fetch the user object from the ID
    $user = User::find($userId);
    $trail->push($user->nomFr . ' ' . $user->prenomFr, route('recapadd.edit', $userId));
});
if (auth()->check() && auth()->user()->role == '1') {
    // Admin Breadcrumbs
    // Notifications
    Breadcrumbs::for('notifications.index', function ($trail) {
        $trail->parent('admin.dashboardadmin');
        $trail->push('Notifications', route('notifications.index'));
    });
    Breadcrumbs::for('notifications.show', function ($trail, $notificationId) {
        $trail->parent('notifications.index');
        $notification = DatabaseNotification::find($notificationId);
        $typeDemande = $notification->data['type_demande'] ?? 'Unknown';
        $trail->push('Demande ' . $typeDemande, route('notifications.show',$notificationId));
    });
// Breadcrumb for Profile Admin Show
Breadcrumbs::for('profileadmin.show', function ($trail, $demandeId) {
    // Fetch the corresponding demande and its user
    $demande = Demande::find($demandeId);

    // Ensure the demande exists
    if ($demande) {
        $userId = $demande->id_user;
        $user = User::find($userId);

        // Fetch the notification associated with this demande
        $notification = DatabaseNotification::where('data->demande_id', $demandeId)->first();

        // Check if notification exists
        if ($notification) {
            $trail->parent('notifications.show', $notification->id);
        } else {
            // Fallback if notification not found
            $trail->parent('notifications.index');
        }

        // Add breadcrumb for the user profile
        $trail->push($user->nomFr . ' ' . $user->prenomFr, route('profileadmin.show', $demandeId));
    } else {
        // Fallback if demande not found
        $trail->parent('notifications.index');
        $trail->push('Profile Not Found', route('profileadmin.show', $demandeId));
    }
});
    // Discussion Public
    Breadcrumbs::for('message.index', function ($trail) {
        $trail->parent('admin.dashboardadmin');
        $trail->push('Discussion Public', route('message.index'));
    });
} elseif (auth()->check() && auth()->user()->role == '0') {
    // Fonctionnaire Breadcrumbs
    // Notifications
    Breadcrumbs::for('notifications.index', function ($trail) {
        $trail->parent('fonctionnaire.dashboard');
        $trail->push('Notifications', route('notifications.index'));
    });
    Breadcrumbs::for('notifications.show', function ($trail, $notificationId) {
        $trail->parent('notifications.index');
        $notification = DatabaseNotification::find($notificationId);
        $trail->push('Demande ' . $notification->data['type_demande'] . ' ' . $notification->data['status'], route('notifications.show',$notificationId));
    });
    // Discussion Public
    Breadcrumbs::for('message.index', function ($trail) {
        $trail->parent('fonctionnaire.dashboard');
        $trail->push('Discussion Public', route('message.index'));
    });
}


// Discussion Privé
Breadcrumbs::for('conversations.index', function ($trail) {
    $trail->parent('admin.dashboardadmin');
    $trail->push('Discussion Privé', route('conversations.index'));
});
Breadcrumbs::for('conversations.show', function ($trail, $user) {
    $trail->parent('conversations.index');
    $trail->push('contacter avec ' . $user->nomFr . ' ' . $user->prenomFr, route('conversations.show', $user->id));
});
Breadcrumbs::for('user.profile', function ($trail, $userId) {
    $user=User::find($userId);
    $trail->parent('conversations.show',$user);
    $trail->push('profile de ' . $user->nomFr . ' ' . $user->prenomFr, route('user.profile', $userId));
});



// Profile Admin
Breadcrumbs::for('profileadmin.index', function ($trail) {
    $trail->parent('admin.dashboardadmin');
    $trail->push('Profile', route('profileadmin.index'));
});

//fonctionnaire
// Fonctionnaire Dashboard
Breadcrumbs::for('fonctionnaire.dashboard', function ($trail) {
    $trail->push('Dashboard', route('fonctionnaire.dashboard'));
});

// Ajouter Demande
Breadcrumbs::for('demandes.create', function ($trail) {
    $trail->parent('fonctionnaire.dashboard');
    $trail->push('Ajouter Demande', route('demandes.create'));
});

// Liste des Demandes
Breadcrumbs::for('demandes.index', function ($trail) {
    $trail->parent('fonctionnaire.dashboard');
    $trail->push('Liste des Demandes', route('demandes.index'));
});


// Fonctionnaire Discussion Privé
Breadcrumbs::for('fonctionnaire.conversations.show', function ($trail) {
    $trail->parent('fonctionnaire.dashboard');
    $trail->push('Discussion Privé', route('fonctionnaire.conversations.show'));
});

// Profile Fonctionnaire
Breadcrumbs::for('profile.index', function ($trail) {
    $trail->parent('fonctionnaire.dashboard');
    $trail->push('Profile', route('profile.index'));
});
