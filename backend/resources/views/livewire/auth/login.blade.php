<div class="login-container d-flex align-items-center justify-content-center">
    <div class="login-card p-4 p-md-5 rounded shadow-lg text-center">
        <div class="mb-4">
            <span class="login-logo fs-3"><i class="bi bi-person-circle"></i></span>
        </div>
        <h2 class="mb-3 fw-bold">Welcome Back!</h2>
        <p class="text-muted mb-4">Please log in to your account</p>

        <form wire:submit.prevent="authenticate">
            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input wire:model.lazy="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" autofocus>
                    @error('email')
                    <div class="invalid-feedback text-start">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input wire:model.lazy="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                    @error('password')
                    <div class="invalid-feedback text-start">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input wire:model.lazy="remember" class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">
                        Remember me
                    </label>
                </div>
                <a href="#" class="text-decoration-none">Forgot Password?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3" wire:loading.attr="disabled">
                <span wire:loading wire:target="authenticate" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Login
            </button>
        </form>

        <p class="text-muted">Don't have an account? <a href="#" class="text-decoration-none">Sign Up</a></p>
    </div>
</div>