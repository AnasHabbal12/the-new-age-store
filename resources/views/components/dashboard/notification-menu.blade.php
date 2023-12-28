<div>
<li class="nav-item dropdown">
   
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          @if($newCount)
          <span class="badge badge-warning navbar-badge">{{ $newCount }}</span>
          @endif
        </a>
    
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">{{ $newCount }} Notifications</span>
          <div class="dropdown-divider"></div>
          @foreach($notifications as $not)
          <a href="{{$not->data['url']}}?notification_id={{$not->id }}" class="dropdown-item @if($not->unread())text-bold @endif">
            <i class="{{$not->data['icon'] }} mr-2"></i> {{$not->data['body'] }}
            <span class="float-right text-muted text-sm">{{ $not->created_at->diffForHumans()}}</span>
          </a>
          <div class="dropdown-divider"></div>
          @endforeach
          
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
</div>