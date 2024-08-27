@include('header')
<div id="show"></div>
<div id="app">
  <!-- <edit-profile :user="{{ $user }}"></edit-profile> -->

  <!-- Header Section -->
  <header
    class="relative bg-cover bg-fixed bg-center text-white py-20"
    style="background-image: linear-gradient(to right bottom, rgba(42, 43, 88, 0.9), rgba(42, 43, 88, 0.9)), url('{{ $user->backimg }}');"
  >
    <div class="text-center">
      <h1 class="text-4xl font-bold">
        <span class="block text-2xl">Welcome</span>
        <span class="block">{{ $user->name }}</span>
      </h1>
      <p class="mt-4 text-lg">
        This is your profile page. You can see the progress you've made with your work and manage your projects or assigned tasks.
      </p>
      <!-- @can('update', $user) -->
      <!-- <button
        class="mt-6 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-full"
        @click="$modal.show('EditProfile')"
      >
        Edit Profile
      </button> -->
      <edit-profile :user="{{ $user }}"></edit-profile>
      <!-- @endcan -->
    </div>
  </header>

  <!-- Main Content -->
  <div class="container mx-auto my-10">
    <div class="flex flex-wrap -mx-4">
      <!-- Profile Sidebar -->
      <div class="w-full md:w-1/3 px-4 mb-8 md:mb-0">
        <div class="bg-white rounded-lg shadow p-6">
          <avatar-form :user="{{ $user }}"></avatar-form>

          <!-- <user-avatar
  :avatar="user.avatar"
  :can-update="userCanUpdate"
  @file-change="handleFileChange"
/> -->

          <div class="flex justify-between mt-4">
            <div class="text-center">
              <span class="block text-xl font-bold">{{ $user->events->count() }}</span>
              <span class="text-sm text-gray-500">Events</span>
            </div>
            <div class="text-center">
              <span class="block text-xl font-bold">{{ $user->replies->count() }}</span>
              <span class="text-sm text-gray-500">Comments</span>
            </div>
            <div class="text-center">
              <span class="block text-xl font-bold">{{ $user->tickets->sum('qty') }}</span>
              <span class="text-sm text-gray-500">Tickets</span>
            </div>
          </div>
          <div class="mt-6">
            <h5 class="text-lg font-semibold">{{ $user->name }}</h5>
            <p class="text-gray-700">{{ $user->email }}</p>
            <p class="text-gray-500 text-sm">{{ $user->created_at->diffForHumans() }}</p>
          </div>
        </div>
      </div>

      <!-- Profile Activity -->
      <div class="w-full md:w-2/3 px-4">
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="text-2xl font-semibold mb-4">Activity Feed</h3>
          <p class="text-gray-700">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis aut cupiditate fugit deleniti voluptatem, fugiat, architecto tempore nesciunt!
          </p>
          <div class="mt-8">
            <p class="font-semibold text-lg">You are a Member of these Events</p>
            <div class="flex flex-wrap -mx-4 mt-4">
              @if($user->tickets->count() == 0)
              <div class="text-center w-full">
                <h3 class="text-xl mb-4">Sorry! No Event Found</h3>
                <a href="/events" class="text-blue-600 hover:underline">Haven't decided to join any event? View all events</a>
              </div>
              @else
              @foreach($user->tickets as $ticket)
              <div class="w-full lg:w-1/2 px-4 mb-6">
                <a href="/events/{{ $ticket->event->slug }}" target="_blank">
                  <div class="bg-gray-100 rounded-lg shadow p-4 hover:bg-gray-200">
                    <div class="flex">
                      <div class="w-1/3">
                        <img src="{{ $ticket->event->image_path }}" alt="" class="rounded-lg">
                        <span class="block mt-2 px-2 py-1 text-xs rounded-full text-white {{ $ticket->event->enddt > \Carbon\Carbon::now()->toDateTimeString() ? 'bg-green-600' : 'bg-red-600' }}">
                          {{ $ticket->event->strtdt->diffForHumans() }}
                        </span>
                        <p class="mt-2 text-sm"><b>Qty: {{ $ticket->qty }}</b></p>
                        <p class="text-sm"><b>Amount: ${{ $ticket->total }}</b></p>
                      </div>
                      <div class="w-2/3 pl-4">
                        <p class="text-lg font-semibold">
                          {!! substr(strip_tags($ticket->event->name), 0, 28) !!}
                        </p>
                        <p class="text-gray-600 text-sm"><b>Start At: {{ $ticket->event->StartDate }}</b></p>
                        <p class="text-gray-500 text-sm"><b>Purchased At: {{ $ticket->created_at }}</b></p>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              @endforeach
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('footer')
