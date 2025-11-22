<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3 ">
        @if (Breadcrumbs::exists())
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @foreach (Breadcrumbs::generate() as $breadcrumb)
                        @if ($breadcrumb->url && !$loop->last)
                            <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb->title }}</li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        @endif
    
      <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 " id="navbar">
        <!--
        <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" id="searchInput" class="form-control" placeholder="Search..." oninput="searchText()">
            </div>
        </div>-->
        </div>
        <ul class="navbar-nav justify-content-end">
          <li class="nav-item d-flex align-items-center">
            <a class="btn btn-outline-primary btn-sm mb-0 me-3" target="_blank" href="/">About Province</a>
          </li>
          <li class="mt-2">
            <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
          </li>
          <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </a>
          </li>
          <li class="nav-item px-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0">
              <i class="fas fa-cog fixed-plugin-button-nav cursor-pointer"></i>
            </a>
          </li>
          
          <!-- Demand Notifications -->
          <li class="nav-item dropdown pe-2 d-flex align-items-center me-3">
            <a href="javascript:;" class="nav-link text-body p-0 position-relative" id="dropdownMenuButtonDemands" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-bell cursor-pointer"></i>
              <span class="badge badge-warning notification-count" id="notificationCountDemands">{{ auth()->user()->unreadNotifications->whereIn('type', ['App\Notifications\DemandeStatusConfirmation', 'App\Notifications\DemandeCreated'])->count() }}</span>
            </a>
            <ul class="dropdown-menu scrollable-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButtonDemands" id="notificationListDemands">
                @foreach(auth()->user()->unreadNotifications->whereIn('type', ['App\Notifications\DemandeStatusConfirmation', 'App\Notifications\DemandeCreated']) as $notification)
                  <li class="mb-2 notification-item" data-id="{{ $notification->id }}" data-type="demand">
                      <a class="dropdown-item border-radius-md" href="{{ route('notifications.show', $notification->id) }}">
                          <div class="d-flex py-1">
                              <div class="my-auto">
                                <!--if useer demander une demande notification va envoyer vers admin avec image de user masi si admin accepte ou refuse notification user va voirs notification avec photo de l'admin-->
                                <!--congé calcule n'intervient pas samedi et demanche-->
                               <!-- Check if the notification has a status (indicating it's a response from the admin) -->
                                @if(isset($notification->data['status']))
                                    <!-- Display admin's photo if the admin responded -->
                                    <img src="{{ asset('upload_files/photos/admin.png') }}" class="avatar avatar-sm me-3"> <!-- Default admin image -->
                                @else
                                    <!-- If there's no status, it means the notification is from the user -->
                                    @if(isset($notification->data['photo']))
                                        <img src="{{ asset('upload_files/photos/' . $notification->data['photo']) }}" class="avatar avatar-sm me-3">
                                    @else
                                        <img src="{{ asset('upload_files/photos/default.png') }}" class="avatar avatar-sm me-3"> <!-- Default user image -->
                                    @endif
                                @endif

                              </div>
                              <div class="d-flex flex-column justify-content-center">
                                  <h6 class="text-sm font-weight-normal mb-1">
                                      @if(isset($notification->data['status']))
                                          Votre demande de type {{ $notification->data['type_demande'] }} a été {{ $notification->data['status'] }}.
                                      @else
                                          Nouvelle demande de type {{ $notification->data['type_demande'] }} par l'utilisateur {{ $notification->data['user_name'] }}
                                      @endif
                                  </h6>
                                  <p class="text-xs text-secondary mb-0">
                                      <i class="fas fa-clock me-1"></i>
                                      {{ $notification->created_at->diffForHumans() }}
                                  </p>
                              </div>
                          </div>
                      </a>
                  </li>
              @endforeach
            </ul>
          </li>
  
          <!-- Notifications for Messages -->
          <li class="nav-item dropdown pe-2 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0 position-relative" id="dropdownMenuButtonMessages" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-comments cursor-pointer"></i>
              <span class="badge badge-warning notification-count" id="notificationCountMessages">{{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\NewMessageNotification')->count() }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4 scrollable-menu" aria-labelledby="dropdownMenuButtonMessages" id="notificationListMessages">
              @foreach(auth()->user()->unreadNotifications->where('type', 'App\Notifications\NewMessageNotification') as $notification)
                  <li class="mb-2 notification-item" data-id="{{ $notification->id }}" data-type="message">
                      <a class="dropdown-item border-radius-md" href="{{ route('notifications.redirect', $notification->id) }}">
                          <div class="d-flex py-1">
                              <div class="my-auto">
                                @if(isset($notification->data['photo']))
                                    <img src="{{ asset('upload_files/photos/' . $notification->data['photo']) }}" class="avatar avatar-sm me-3">
                                @else
                                    <img src="{{ asset('upload_files/photos/admin.png') }}" class="avatar avatar-sm me-3"> <!-- Default image -->
                                @endif
                              </div>
                              <div class="d-flex flex-column justify-content-center">
                                  <h6 class="text-sm font-weight-normal mb-1">
                                    Nouveau message de {{ $notification->data['sender'] }}
                                  </h6>
                                  <p class="text-xs text-secondary mb-0">
                                      <i class="fas fa-clock me-1"></i>
                                      {{ $notification->created_at->diffForHumans() }}
                                  </p>
                              </div>
                          </div>
                      </a>
                  </li>
              @endforeach
            </ul>
          </li>
          <!-- Notifications for Public Messages -->
          <li class="nav-item dropdown pe-2 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0 position-relative" id="dropdownMenuButtonPublicMessages" data-bs-toggle="dropdown" aria-expanded="false">
               <i class="fas fa-globe cursor-pointer"></i>
              <span class="badge badge-warning notification-count" id="notificationCountPublicMessages">{{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\NewNotificationPublic')->count() }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4 scrollable-menu" aria-labelledby="dropdownMenuButtonPublicMessages" id="notificationListPublicMessages">
              @foreach(auth()->user()->unreadNotifications->where('type', 'App\Notifications\NewNotificationPublic') as $notification)
                  <li class="mb-2 notification-item" data-id="{{ $notification->id }}" data-type="public_message">
                      <a class="dropdown-item border-radius-md" href="{{ route('notifications.redirect', $notification->id) }}">
                          <div class="d-flex py-1">
                              <div class="my-auto">
                                @if(isset($notification->data['photo']))
                                    <img src="{{ asset('upload_files/photos/' . $notification->data['photo']) }}" class="avatar avatar-sm me-3">
                                @else
                                    <img src="{{ asset('upload_files/photos/admin.png') }}" class="avatar avatar-sm me-3"> <!-- Default image -->
                                @endif
                              </div>
                              <div class="d-flex flex-column justify-content-center">
                                  <h6 class="text-sm font-weight-normal mb-1">
                                    Nouveau message public de {{ $notification->data['sender'] }}
                                  </h6>
                                  <p class="text-xs text-secondary mb-0">
                                      <i class="fas fa-clock me-1"></i>
                                      {{ $notification->created_at->diffForHumans() }}
                                  </p>
                              </div>
                          </div>
                      </a>
                  </li>
              @endforeach
            </ul>
          </li>          
          
          <li class="nav-item d-flex align-items-center">
            <a class="nav-link text-body font-weight-bold px-0" href="{{ route('logout') }}"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
              <i class="fas fa-user me-sm-1"></i>
              <span class="d-sm-inline d-none">Se déconnecter</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <style>
    .notification-count {
        position: absolute;
        top: -10px;
        right: -10px;
        padding: 5px 10px;
        border-radius: 50%;
        background-color: red;
        color: white;
        font-size: 12px;
        font-weight: bold;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 24px;
        height: 24px;
        z-index: 10;
    }
  
    .navbar-nav .nav-link i.fa-bell,
    .navbar-nav .nav-link i.fa-comments,
    .navbar-nav .nav-link i.fa-globe {
        font-size: 20px;
        color: #343a40;
    }
  
    .notification-item {
        cursor: pointer;
        margin-bottom: 10px; /* Add space between notification items */
        border-bottom: 1px solid #e0e0e0; /* Optional: add a separator line */
        padding-bottom: 10px; /* Add padding at the bottom of each notification item */
    }
  
    .notification-item:last-child {
        margin-bottom: 0; /* Remove margin for the last notification item */
    }
  
    .dropdown-menu.scrollable-menu {
      max-height: 300px; /* Adjust the height as needed */
      overflow-y: auto;
    }
  
    .nav-item {
        margin-right: 15px; /* Add space between icons */
    }
  
    .nav-item:last-child {
        margin-right: 0; /* Remove margin for the last icon if needed */
    }
  </style>
  
  
  <script>

    document.addEventListener('DOMContentLoaded', function() {
        const notificationListDemands = document.getElementById('notificationListDemands');
        const notificationCountDemands = document.getElementById('notificationCountDemands');
        const notificationListMessages = document.getElementById('notificationListMessages');
        const notificationCountMessages = document.getElementById('notificationCountMessages');
        const notificationListPublicMessages = document.getElementById('notificationListPublicMessages');
        const notificationCountPublicMessages = document.getElementById('notificationCountPublicMessages');
        var authUserId = {{ json_encode(auth()->id()) }};

        function addNotification(notification, type) {
            const notificationHtml = `
                <li class="mb-2 notification-item" data-id="${notification.id}" data-type="${type}">
                    <a class="dropdown-item border-radius-md" href="/notifications/redirect/${notification.id}">
                        <div class="d-flex py-1">
                            <div class="my-auto">
                                @if(isset($notification->data['photo']))
                                    <img src="{{ asset('upload_files/photos/' . $notification->data['photo']) }}" class="avatar avatar-sm me-3">
                                @else
                                    <img src="{{ asset('upload_files/photos/admin.png') }}" class="avatar avatar-sm me-3"> <!-- Default image -->
                                @endif
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">${notification.data.message}</h6>
                                <p class="text-xs text-secondary mb-0">
                                    <i class="fas fa-clock me-1"></i>
                                    ${notification.created_at}
                                </p>
                            </div>
                        </div>
                    </a>
                </li>
            `;

            if (type === 'demand') {
                notificationListDemands.innerHTML += notificationHtml;
                notificationCountDemands.innerText = parseInt(notificationCountDemands.innerText) + 1;
                notificationCountDemands.style.display = 'block';
            } else if (type === 'message') {
                notificationListMessages.innerHTML += notificationHtml;
                notificationCountMessages.innerText = parseInt(notificationCountMessages.innerText) + 1;
                notificationCountMessages.style.display = 'block';
            } else if (type === 'public_message') {
                notificationListPublicMessages.innerHTML += notificationHtml;
                notificationCountPublicMessages.innerText = parseInt(notificationCountPublicMessages.innerText) + 1;
                notificationCountPublicMessages.style.display = 'block';
            }
        }

        Echo.private('App.Models.User.' + authUserId)
            .notification((notification) => {
                if (notification.type === 'App\\Notifications\\DemandeStatusConfirmation' || notification.type === 'App\\Notifications\\DemandeCreated') {
                    addNotification(notification, 'demand');
                } else if (notification.type === 'App\\Notifications\\NewMessageNotification') {
                    addNotification(notification, 'message');
                } else if (notification.type === 'App\\Notifications\\NewNotificationPublic') {
                    addNotification(notification, 'public_message');
                }
                console.log(notification,'new notification');
        });

    
        function markAsReadAndRedirect(notificationItem, type) {
            const notificationId = notificationItem.dataset.id;
    
            fetch(/notifications/mark-as-read/${notificationId}, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    notificationItem.remove();
                    let countElement;
                    if (type === 'demand') {
                        countElement = notificationCountDemands;
                    } else if (type === 'message') {
                        countElement = notificationCountMessages;
                    } else if (type === 'public_message') {
                        countElement = notificationCountPublicMessages;
                    }
                    const newCount = parseInt(countElement.innerText) - 1;
                    countElement.innerText = newCount > 0 ? newCount : '';
                    if (newCount <= 0) {
                        countElement.style.display = 'none';
                    }
    
                    if (type === 'message') {
                        window.location.href = /conversations/show/${data.conversation_id};
                    } else if (type === 'demand') {
                        window.location.href = /demands/${notificationId};
                    } else if (type === 'public_message') {
                        window.location.href = /public-messages/${notificationId};
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }
    
        if (notificationListDemands) {
            notificationListDemands.addEventListener('click', function(e) {
                const notificationItem = e.target.closest('.notification-item');
                if (notificationItem) {
                    markAsReadAndRedirect(notificationItem, 'demand');
                }
            });
        }
    
        if (notificationListMessages) {
            notificationListMessages.addEventListener('click', function(e) {
                const notificationItem = e.target.closest('.notification-item');
                if (notificationItem) {
                    markAsReadAndRedirect(notificationItem, 'message');
                }
            });
        }
    
        if (notificationListPublicMessages) {
            notificationListPublicMessages.addEventListener('click', function(e) {
                const notificationItem = e.target.closest('.notification-item');
                if (notificationItem) {
                    markAsReadAndRedirect(notificationItem, 'public_message');
                }
            });
        }
    });
    </script>