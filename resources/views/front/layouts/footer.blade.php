<footer class="bg-primary text-white text-center">
    <div class="footer-links py-5 px-3">
        <a href="{{ route('front.page', 'about') }}">About Us</a>
        <a href="{{ route('front.page', 'contact') }}">Contact Us</a>
        <a href="{{ route('front.page', 'terms') }}">Terms and Conditions</a>
        <a href="{{ route('front.page', 'privacy') }}">Privacy Policy</a>
    </div>
    <div class="py-2 px-3 copyright">
        Copyright &copy; {{ date ("Y") }} - {{ config("app.name") }}
    </div>
</footer>