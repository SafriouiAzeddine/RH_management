<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?php echo e(route('accueil')); ?>"><i class="fas fa-home"></i> Accueil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownActualites" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Actualités
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownActualites">
                    <a class="dropdown-item" href="<?php echo e(route('news.events')); ?>">Événements</a>
                    <a class="dropdown-item" href="<?php echo e(route('news.journals')); ?>">Journaux</a>
                    <a class="dropdown-item" href="<?php echo e(route('news.weather')); ?>">Météo</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAbout" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    À propos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownAbout">
                    <a class="dropdown-item" href="<?php echo e(route('about.provinceRhamna')); ?>">Province Rhamna</a>
                    <a class="dropdown-item" href="<?php echo e(route('about.directeurRH')); ?>">Directeur RH</a>
                    <a class="dropdown-item" href="<?php echo e(route('about.divisionRH')); ?>">Division RH</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('contact')); ?>">Contact</a>
            </li>
            <?php if(Route::has('login')): ?>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->role == '1'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('admin.dashboardadmin')); ?>">Revenir à votre tableau de bord admin</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('fonctionnaire.dashboard')); ?>">Retourner à votre tableau de bord fonctionnaire"</a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('login')); ?>">Se connecter</a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
    </div>
</nav><?php /**PATH C:\xampp\htdocs\Application_RH_v17_08_vf\Application_RH_v26_07\resources\views/welcomelayout/navbar.blade.php ENDPATH**/ ?>