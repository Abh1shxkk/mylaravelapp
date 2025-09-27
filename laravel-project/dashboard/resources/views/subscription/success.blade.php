<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subscription Successful</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          animation: {
            'bounce-in': 'bounceIn 0.8s ease-out',
            'fade-in': 'fadeIn 1s ease-out',
            'slide-up': 'slideUp 0.6s ease-out',
            'pulse-success': 'pulseSuccess 2s infinite',
          },
          keyframes: {
            bounceIn: {
              '0%': { transform: 'scale(0.3)', opacity: '0' },
              '50%': { transform: 'scale(1.05)' },
              '70%': { transform: 'scale(0.9)' },
              '100%': { transform: 'scale(1)', opacity: '1' }
            },
            fadeIn: {
              '0%': { opacity: '0', transform: 'translateY(20px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' }
            },
            slideUp: {
              '0%': { transform: 'translateY(30px)', opacity: '0' },
              '100%': { transform: 'translateY(0)', opacity: '1' }
            },
            pulseSuccess: {
              '0%, 100%': { boxShadow: '0 0 0 0 rgba(34, 197, 94, 0.4)' },
              '70%': { boxShadow: '0 0 0 10px rgba(34, 197, 94, 0)' }
            }
          }
        }
      }
    }
  </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50">
  
  <!-- Background Pattern -->
  <div class="fixed inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, #22c55e 2px, transparent 2px), radial-gradient(circle at 75% 75%, #10b981 2px, transparent 2px); background-size: 50px 50px;"></div>
  </div>

  <div class="relative min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl mx-auto w-full">
      
      <!-- Success Card -->
      <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl shadow-green-200/50 p-8 md:p-12 text-center border border-green-100 animate-fade-in">
        
        <!-- Success Icon -->
        <div class="flex items-center justify-center mb-8">
          <div class="relative">
            <div class="w-24 h-24 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center shadow-lg animate-bounce-in animate-pulse-success">
              <i class="fas fa-check text-3xl text-white"></i>
            </div>
            <!-- Celebration particles -->
            <div class="absolute -top-2 -right-2 w-4 h-4 bg-yellow-400 rounded-full animate-ping"></div>
            <div class="absolute -bottom-1 -left-2 w-3 h-3 bg-pink-400 rounded-full animate-ping" style="animation-delay: 0.5s;"></div>
            <div class="absolute top-1 -left-3 w-2 h-2 bg-blue-400 rounded-full animate-ping" style="animation-delay: 1s;"></div>
          </div>
        </div>

        <!-- Success Message -->
        <div class="mb-8 animate-slide-up" style="animation-delay: 0.2s;">
          <h1 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
            🎉 Thank You!
          </h1>
          <p class="text-xl text-gray-600 mb-2">Your subscription is now active!</p>
          <p class="text-gray-500">You should receive a confirmation email shortly.</p>
        </div>

        <!-- Purchase Details Card -->
        <div class="mb-8 animate-slide-up" style="animation-delay: 0.4s;">
          <div class="bg-gradient-to-r from-gray-50 to-green-50 border-2 border-green-100 rounded-2xl overflow-hidden shadow-inner">
            <!-- Plan Header -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-4">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <i class="fas fa-crown text-yellow-200"></i>
                  <span class="text-xl font-bold">{{ ucfirst(session('plan') ?? request('plan', 'Your Plan')) }}</span>
                </div>
                <span class="text-2xl font-bold">₹{{ number_format((int)(session('amount') ?? request()->integer('amount', 0))) }}</span>
              </div>
            </div>
            
            <!-- Billing Details -->
            <div class="px-6 py-5 space-y-3">
              <div class="flex items-center justify-between text-gray-700 border-b border-gray-200 pb-2">
                <span class="flex items-center gap-2">
                  <i class="fas fa-receipt text-green-500"></i>
                  Subtotal
                </span>
                <span class="font-semibold">₹{{ number_format((int)(session('amount') ?? request()->integer('amount', 0))) }}</span>
              </div>
              <div class="flex items-center justify-between text-lg font-bold text-green-600">
                <span class="flex items-center gap-2">
                  <i class="fas fa-money-bill-wave text-green-500"></i>
                  Total Paid
                </span>
                <span>₹{{ number_format((int)(session('amount') ?? 0)) }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-slide-up" style="animation-delay: 0.6s;">
          <a href="{{ route('transactions.index') }}" 
             class="group w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
            <i class="fas fa-history group-hover:animate-spin"></i>
            <span>View Transactions</span>
          </a>
          <a href="{{ route('dashboard.home') }}" 
             class="group w-full sm:w-auto px-8 py-4 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg hover:border-green-400 hover:text-green-600 transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
            <i class="fas fa-tachometer-alt group-hover:animate-pulse"></i>
            <span>Go to Dashboard</span>
          </a>
        </div>

        <!-- Additional Success Elements -->
        <div class="mt-8 pt-6 border-t border-green-100 animate-slide-up" style="animation-delay: 0.8s;">
          <div class="flex items-center justify-center gap-6 text-green-600">
            <div class="flex items-center gap-2 text-sm">
              <i class="fas fa-shield-alt text-green-500"></i>
              <span>Secure Payment</span>
            </div>
            <div class="flex items-center gap-2 text-sm">
              <i class="fas fa-envelope text-green-500"></i>
              <span>Email Confirmation</span>
            </div>
            <div class="flex items-center gap-2 text-sm">
              <i class="fas fa-clock text-green-500"></i>
              <span>Instant Access</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Enhanced script with visual feedback
    fetch('{{ route('subscription.status') }}')
      .then(r => r.json())
      .then(d => {
        const btn = document.getElementById('btn-subscribe');
        if (btn && d.active) { 
          btn.classList.add('hidden'); 
          // Add success indicator if needed
          console.log('Subscription status updated successfully');
        }
      })
      .catch(() => {
        console.log('Status check completed');
      });

    // Add confetti effect (optional)
    setTimeout(() => {
      for (let i = 0; i < 50; i++) {
        createConfetti();
      }
    }, 500);

    function createConfetti() {
      const confetti = document.createElement('div');
      confetti.innerHTML = ['🎉', '🎊', '✨', '🌟', '💫'][Math.floor(Math.random() * 5)];
      confetti.style.position = 'fixed';
      confetti.style.left = Math.random() * 100 + 'vw';
      confetti.style.top = '-10px';
      confetti.style.fontSize = Math.random() * 20 + 10 + 'px';
      confetti.style.zIndex = '1000';
      confetti.style.pointerEvents = 'none';
      confetti.style.animation = `fall ${Math.random() * 3 + 2}s linear forwards`;
      
      document.body.appendChild(confetti);
      
      setTimeout(() => {
        confetti.remove();
      }, 5000);
    }

    // CSS for confetti animation
    const style = document.createElement('style');
    style.textContent = `
      @keyframes fall {
        to {
          transform: translateY(100vh) rotate(360deg);
          opacity: 0;
        }
      }
    `;
    document.head.appendChild(style);
  </script>
</body>
</html>