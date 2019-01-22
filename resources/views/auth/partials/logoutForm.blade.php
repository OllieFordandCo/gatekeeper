<form id="logout-form" action="{{ route('logout') }}" method="POST">
 @csrf
 <fieldset class="py-2">
  <legend class="small text-center">You are logged in!</legend>
  <button type="submit" class="d-block mx-auto btn btn-border-grey">Logout</button>
 </fieldset>
</form>