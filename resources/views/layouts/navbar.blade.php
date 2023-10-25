<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
          </svg>
      </button>
        <a href="{{ route('home') }}">
            <x-logo class="w-auto h-16 mx-auto text-indigo-600" />
        </a>
      <div class="hidden w-full md:flex md:w-auto" id="navbar-default">
        <ul class="font-medium flex flex-col p-6 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700 justify-end">
          @if (Route::has('login'))
            @auth
              <li>
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white sm:px-4">{{ __('Go Home') }}</a>
              </li>
              <li>
                <a href="{{ route('todos') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white sm:px-4">{{ __('Todo List') }}</a>
              </li>
              <li>
                <a href="{{ route('logout') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white sm:px-4">{{ __('Log out') }}</a>
              </li>
            @else
                <li>
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white sm:px-4">{{ __('Log in') }}</a>
                </li>
                @if (Route::has('register'))
                    <li>
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white sm:px-4">{{ __('Register') }}</a>
                    </li>
                @endif
            @endauth
            @endif
            @foreach (config('app.supported_locales') as $locale)
            <div class="mt-4 sm:mt-0">
                
                <li>
                    <a href="{{ route('change.locale', $locale) }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500 inline-block mx-2">{{ strtoupper($locale) }}</a>
                </li>
                
            </div>
            @endforeach

        </ul>
      </div>
    </div>
  </nav>
  