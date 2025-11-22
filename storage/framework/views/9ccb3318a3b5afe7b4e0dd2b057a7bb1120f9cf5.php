<div class="carousel-container">
    <div class="owl-carousel owl-theme">
        <div class="item">
            <div class="overlay">
                <h2>Bienvenue sur notre système de gestion des RH</h2>
                <p>Votre solution tout-en-un pour la gestion des ressources humaines.</p>
            </div>
            <img src="<?php echo e(asset('images/img1.jpg')); ?>" alt="Slide 1">
        </div>
        <div class="item">
            <div class="overlay">
                <h2>Gestion des Employés</h2>
                <p>Gérez et suivez efficacement les informations des employés.</p>
            </div>
            <img src="<?php echo e(asset('images/img2.jpg')); ?>" alt="Slide 2">
        </div>
        <div class="item">
            <div class="overlay">
                <h2>Demandes de Congés</h2>
                <p>Rationalisez les demandes et les approbations de congés.</p>
            </div>
            <img src="<?php echo e(asset('images/img3.jpg')); ?>" alt="Slide 3">
        </div>
    </div>

</div>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <cs-article-card-24></cs-article-card-24>
        </div>
        <div class="col-md-6">
            <cs-infopane-card></cs-infopane-card>
        </div>
    </div>
</div>

<div class="ai-helper-container">
    <button id="ai-helper">AI helper</button>
    <div id="chatbox">
        <div id="chatbox-body"></div>
        <div id="chatbox-footer">
            <input type="text" id="chatbox-input" placeholder="Posez votre question...">
            <button id="send-btn">Envoyer</button>
        </div>
        <div id="close-chatbox">&times;</div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\Application_RH_v17_08_vf\Application_RH_v26_07\resources\views/welcomelayout/maincontent.blade.php ENDPATH**/ ?>