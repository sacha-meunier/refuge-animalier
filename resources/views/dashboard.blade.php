<form method="POST" action="{{ route("logout") }}" class="w-full">
    @csrf
    <x-button type="submit">Logout</x-button>
</form>
