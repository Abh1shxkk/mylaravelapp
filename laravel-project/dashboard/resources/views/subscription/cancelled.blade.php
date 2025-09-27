<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subscription Cancelled</title>
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
            'pulse-warning': 'pulseWarning 2s infinite',
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
            pulseWarning: {
              '0%, 100%': { boxShadow: '0 0 0 0 rgba(239, 68, 68, 0.4)' },
              '70%': { boxShadow: '0 0 0 10px rgba(239, 68, 68, 0)' }
            }
          }
        }
      }
    }
  </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-red-50 via-orange-50 to-pink-50">
  
  <!-- Background Pattern -->
  <div class="fixed inset-0 opacity-5">
    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, #ef4444 2px, transparent 2px), radial-gradient(circle at 75% 75%, #f97316 2px, transparent 2px); background-size: 50px 50px;"></div>
  </div>

  <div class="relative min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl mx-auto w-full">
      
      <!-- Cancelled Card -->
      <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl shadow-red-200/50 p-8 md:p-12 text-center border border-red-100 animate-fade-in">
        
        <!-- Cancelled Icon -->
        <div class="flex items-center justify-center mb-8">
          <div class="relative">
            <div class="w-24 h-24 rounded-full bg-gradient-to-r from-red-400 to-orange-500 flex items-center justify-center shadow-lg animate-bounce-in animate-pulse-warning">
              <i class="fas fa-times text-3xl text-white"></i>
            </div>
            <!-- Warning particles -->
            <div class="absolute -top-2 -right-2 w-4 h-4 bg-yellow-400 rounded-full animate-ping"></div>
            <div class="absolute -bottom-1 -left-2 w-3 h-3 bg-orange-400 rounded-full animate-ping" style="animation-delay: 0.5s;"></div>
            <div class="absolute top-1 -left-3 w-2 h-2 bg-red-400 rounded-full animate-ping" style="animation-delay: 1s;"></div>
          </div>
        </div>

        <!-- Cancelled Message -->
        <div class="mb-8 animate-slide-up" style="animation-delay: 0.2s;">
          <h1 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">
            Subscription Cancelled
          </h1>
          <p class="text-xl text-gray-600 mb-2">Your subscription has been cancelled successfully.</p>
          <p class="text-gray-500">We're sorry to see you go!</p>
        </div>

        <!-- Cancellation Details Card -->
        <div class="mb-8 animate-slide-up" style="animation-delay: 0.4s;">
          <div class="bg-gradient-to-r from-gray-50 to-red-50 border-2 border-red-100 rounded-2xl overflow-hidden shadow-inner">
            <!-- Status Header -->
            <div class="bg-gradient-to-r from-red-500 to-orange-500 text-white px-6 py-4">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <i class="fas fa-times-circle text-red-200"></i>
                  <span class="text-xl font-bold">Subscription Status</span>
                </div>
                <span class="text-2xl font-bold">CANCELLED</span>
              </div>
            </div>
            
            <!-- Status Details -->
            <div class="px-6 py-5 space-y-3">
              <div class="flex items-center justify-between text-gray-700 border-b border-gray-200 pb-2">
                <span class="flex items-center gap-2">
                  <i class="fas fa-calendar-times text-red-500"></i>
                  Status
                </span>
                <span class="font-semibold text-red-600">Cancelled</span>
              </div>
              <div class="flex items-center justify-between text-lg font-bold text-red-600">
                <span class="flex items-center gap-2">
                  <i class="fas fa-ban text-red-500"></i>
                  Access Level
                </span>
                <span>Limited</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-slide-up" style="animation-delay: 0.6s;">
          <a href="{{ route('dashboard.home') }}" 
             class="group w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
            <i class="fas fa-tachometer-alt group-hover:animate-spin"></i>
            <span>Go to Dashboard</span>
          </a>
          <button onclick="openSubscribe()" 
                  class="group w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
            <i class="fas fa-crown group-hover:animate-pulse"></i>
            <span>Choose a Plan</span>
          </button>
        </div>

        <!-- Additional Cancelled Elements -->
        <div class="mt-8 pt-6 border-t border-red-100 animate-slide-up" style="animation-delay: 0.8s;">
          <div class="flex items-center justify-center gap-6 text-red-600">
            <div class="flex items-center gap-2 text-sm">
              <i class="fas fa-times-circle text-red-500"></i>
              <span>Premium Disabled</span>
            </div>
            <div class="flex items-center gap-2 text-sm">
              <i class="fas fa-clock text-red-500"></i>
              <span>Immediate Effect</span>
            </div>
            <div class="flex items-center gap-2 text-sm">
              <i class="fas fa-undo text-red-500"></i>
              <span>Can Resubscribe</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function openSubscribe(){
      try { if (window.openModal) openModal('modal-subscribe'); } catch(e) {}
      window.location.href = '{{ route('dashboard.home') }}#plans';
    }

    // Add floating cancel elements (optional)
    setTimeout(() => {
      for (let i = 0; i < 30; i++) {
        createCancelElements();
      }
    }, 500);

    function createCancelElements() {
      const elements = ['❌', '💔', '😢', '👋', '🚫'];
      const element = document.createElement('div');
      element.innerHTML = elements[Math.floor(Math.random() * elements.length)];
      element.style.position = 'fixed';
      element.style.left = Math.random() * 100 + 'vw';
      element.style.top = '-10px';
      element.style.fontSize = Math.random() * 20 + 10 + 'px';
      element.style.zIndex = '1000';
      element.style.pointerEvents = 'none';
      element.style.animation = `fall ${Math.random() * 3 + 2}s linear forwards`;
      
      document.body.appendChild(element);
      
      setTimeout(() => {
        element.remove();
      }, 5000);
    }

    // CSS for falling animation
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