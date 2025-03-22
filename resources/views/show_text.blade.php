<style>
    .text-center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        /* Full viewport height */
        font-size: 2rem;
        font-family: Arial, sans-serif;
        color: red;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

<div class="text-center">
    <span id="typed"></span>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typed = new Typed('#typed', {
            strings: [
                `Hello, Our next sallary is pending. Please pay the sallary and get myself active. Let's get it discussed.
                Arrange a meeting yourself and let me know the link `
            ],
            typeSpeed: 50,
            backSpeed: 90,
            loop: true,
            showCursor: false, // Hide the cursor
        });
    });
</script>
