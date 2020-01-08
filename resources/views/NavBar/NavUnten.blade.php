<footer class="row mt-2 border-top">
  <div class="col-4">
    <p>{{ date("d/m/Y") }}</p>
  </div>
  <div class="col-8">
    <a href="{{ route('login') }}" class="link p-1 border-right">Login</a>
    <a href="{{ route('register') }}" class="link p-1 border-right">Registrieren</a>
    <a href="{{ route('ingredients') }}" class="link p-1 border-right btn-link">Zutatenliste</a>
    <a href="{{ route('imprint') }}" class="link p-1">Impressum</a>
  </div>
</footer>
