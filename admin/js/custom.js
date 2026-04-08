/**
 * Motamkin Admin - Ultra Premium JavaScript
 * Enhancement Round: Clean, White, Professional, Expensive
 */

(function() {
  'use strict';

  // ==========================================
  // SIDEBAR TOGGLE HANDLING
  // ==========================================
  const sidebar = document.getElementById('sidebarMenu');
  const toggler = document.querySelector('.navbar-toggler');
  
  if (sidebar && toggler) {
    // Show sidebar on toggle button click
    toggler.addEventListener('click', function() {
      sidebar.classList.toggle('show');
      document.body.classList.toggle('sidebar-open');
    });
    
    // Close sidebar when clicking outside on tablet/mobile
    document.addEventListener('click', function(e) {
      if (window.innerWidth < 1200) {
        if (!sidebar.contains(e.target) && !toggler.contains(e.target)) {
          sidebar.classList.remove('show');
          document.body.classList.remove('sidebar-open');
        }
      }
    });
    
    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
        document.body.classList.remove('sidebar-open');
      }
    });
  }

  // ==========================================
  // COLLAPSE ARROW ROTATION
  // ==========================================
  window.rotateArrow = function(button) {
    const arrow = button.querySelector('.arrow-icon');
    if (arrow) {
      arrow.classList.toggle('rotated');
    }
  };

  // ==========================================
  // COLLAPSE EVENT LISTENERS
  // ==========================================
  const collapseElements = document.querySelectorAll('.collapse');
  
  collapseElements.forEach(function(collapse) {
    collapse.addEventListener('show.bs.collapse', function() {
      const button = document.querySelector('[data-bs-target="#' + this.id + '"]');
      if (button) {
        const arrow = button.querySelector('.arrow-icon');
        if (arrow) {
          arrow.classList.add('rotated');
        }
      }
    });
    
    collapse.addEventListener('hide.bs.collapse', function() {
      const button = document.querySelector('[data-bs-target="#' + this.id + '"]');
      if (button) {
        const arrow = button.querySelector('.arrow-icon');
        if (arrow) {
          arrow.classList.remove('rotated');
        }
      }
    });
  });

  // ==========================================
  // FORM SUBMISSION HANDLING
  // ==========================================
  const forms = document.querySelectorAll('form');
  
  forms.forEach(function(form) {
    form.addEventListener('submit', function(e) {
      const submitBtn = form.querySelector('[type="submit"], .submit-btn');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> جاري الإضافة...';
        
        // Re-enable after 5 seconds if not submitted
        setTimeout(function() {
          submitBtn.disabled = false;
        }, 5000);
      }
    });
  });

  // ==========================================
  // AUTO-DISMISS ALERTS WITH ANIMATION
  // ==========================================
  const alerts = document.querySelectorAll('.alert, .success-message, .error-message');
  
  alerts.forEach(function(alert) {
    setTimeout(function() {
      alert.style.opacity = '0';
      alert.style.transform = 'translateY(-10px) scale(0.95)';
      alert.style.transition = 'all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
      
      setTimeout(function() {
        alert.remove();
      }, 400);
    }, 6000);
  });

  // ==========================================
  // NUMBER INPUT FORMATTING
  // ==========================================
  const numberInputs = document.querySelectorAll('input[name="number"], input[name="number_two"]');
  
  numberInputs.forEach(function(input) {
    input.addEventListener('input', function(e) {
      // Remove any non-digit characters
      this.value = this.value.replace(/[^\d]/g, '');
      
      // Format as phone number
      if (this.value.length > 10) {
        this.value = this.value.slice(0, 10);
      }
    });
    
    // Add focus animation
    input.addEventListener('focus', function() {
      this.parentElement.classList.add('focused');
    });
    
    input.addEventListener('blur', function() {
      this.parentElement.classList.remove('focused');
    });
  });

  // ==========================================
  // PRICE INPUT VALIDATION
  // ==========================================
  const priceInputs = document.querySelectorAll('input[name="price"]');
  
  priceInputs.forEach(function(input) {
    input.addEventListener('input', function(e) {
      // Allow only digits and decimal point
      this.value = this.value.replace(/[^\d.]/g, '');
      
      // Ensure only one decimal point
      const parts = this.value.split('.');
      if (parts.length > 2) {
        this.value = parts[0] + '.' + parts.slice(1).join('');
      }
      
      // Limit decimal places
      if (parts.length === 2 && parts[1].length > 2) {
        this.value = parts[0] + '.' + parts[1].slice(0, 2);
      }
    });
  });

  // ==========================================
  // SCROLL ANIMATIONS WITH INTERSECTION OBSERVER
  // ==========================================
  const animatedElements = document.querySelectorAll('.elite-card, .form-card, .box, .filter');
  
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry, index) {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
          entry.target.classList.add('animated');
        }
      });
    }, {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    });
    
    animatedElements.forEach(function(el, index) {
      el.style.opacity = '0';
      el.style.transform = 'translateY(30px)';
      el.style.transition = 'opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1), transform 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
      el.style.transitionDelay = (index * 0.08) + 's';
      observer.observe(el);
    });
  }

  // ==========================================
  // SMOOTH TRANSITIONS FOR FOCUS STATES
  // ==========================================
  const focusableElements = document.querySelectorAll('.form-control, .form-select');
  
  focusableElements.forEach(function(el) {
    el.addEventListener('focus', function() {
      this.parentElement.classList.add('focused');
    });
    
    el.addEventListener('blur', function() {
      this.parentElement.classList.remove('focused');
    });
  });

  // ==========================================
  // BUTTON RIPPLE EFFECT
  // ==========================================
  const buttons = document.querySelectorAll('.submit-btn, .btn-primary');
  
  buttons.forEach(function(button) {
    button.addEventListener('click', function(e) {
      const rect = button.getBoundingClientRect();
      const ripple = document.createElement('span');
      const size = Math.max(rect.width, rect.height);
      const x = e.clientX - rect.left - size / 2;
      const y = e.clientY - rect.top - size / 2;
      
      ripple.style.cssText = 
        'position: absolute;' +
        'border-radius: 50%;' +
        'width: ' + size + 'px;' +
        'height: ' + size + 'px;' +
        'left: ' + x + 'px;' +
        'top: ' + y + 'px;' +
        'background: rgba(255, 255, 255, 0.3);' +
        'transform: scale(0);' +
        'animation: ripple 0.6s linear;' +
        'pointer-events: none;';
      
      button.appendChild(ripple);
      
      setTimeout(function() {
        ripple.remove();
      }, 600);
    });
  });

  // ==========================================
  // COUNTER ANIMATION FOR STATS
  // ==========================================
  const statNumbers = document.querySelectorAll('.box h2');
  
  statNumbers.forEach(function(stat) {
    const target = parseInt(stat.textContent);
    const duration = 1000;
    const step = target / (duration / 16);
    let current = 0;
    
    const counter = setInterval(function() {
      current += step;
      if (current >= target) {
        stat.textContent = target;
        clearInterval(counter);
      } else {
        stat.textContent = Math.floor(current);
      }
    }, 16);
  });

  // ==========================================
  // SMOOTH SCROLL TO ELEMENTS
  // ==========================================
  const scrollLinks = document.querySelectorAll('a[href^="#"]');
  
  scrollLinks.forEach(function(link) {
    link.addEventListener('click', function(e) {
      const targetId = this.getAttribute('href');
      if (targetId !== '#') {
        e.preventDefault();
        const target = document.querySelector(targetId);
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      }
    });
  });

  // ==========================================
  // ACTIVE NAVIGATION HIGHLIGHT
  // ==========================================
  const currentPath = window.location.pathname;
  const navLinks = document.querySelectorAll('.sidebar .nav-link');
  
  navLinks.forEach(function(link) {
    if (link.getAttribute('href') === currentPath) {
      link.classList.add('active');
    }
  });

  // ==========================================
  // PRELOADER ANIMATION
  // ==========================================
  window.addEventListener('load', function() {
    document.body.classList.add('loaded');
    
    // Animate page title
    const pageTitle = document.querySelector('.page-title');
    if (pageTitle) {
      pageTitle.style.opacity = '0';
      pageTitle.style.transform = 'translateY(-20px)';
      setTimeout(function() {
        pageTitle.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        pageTitle.style.opacity = '1';
        pageTitle.style.transform = 'translateY(0)';
      }, 200);
    }
  });

  // ==========================================
  // KEYBOARD SHORTCUTS
  // ==========================================
  document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + S to submit form
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
      e.preventDefault();
      const form = document.querySelector('.add-form');
      if (form) {
        form.submit();
      }
    }
    
    // Ctrl/Cmd + N to focus next input
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
      e.preventDefault();
      const inputs = Array.from(document.querySelectorAll('.form-control, .form-select'));
      const focused = document.activeElement;
      const index = inputs.indexOf(focused);
      if (index !== -1 && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
    }
  });

  // ==========================================
  // RIPPLE ANIMATION CSS
  // ==========================================
  const style = document.createElement('style');
  style.textContent = `
    @keyframes ripple {
      to {
        transform: scale(4);
        opacity: 0;
      }
    }
  `;
  document.head.appendChild(style);

  // ==========================================
  // STAGGERED CARD ANIMATION
  // ==========================================
  document.querySelectorAll('.row .elite-card').forEach(function(card, index) {
    card.style.animationDelay = (index * 0.1) + 's';
    card.classList.add('staggered');
  });

  // ==========================================
  // SKELETON LOADING (Optional Enhancement)
  // ==========================================
  window.showSkeleton = function(element) {
    element.classList.add('skeleton');
    element.style.animation = 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite';
  };

  window.hideSkeleton = function(element) {
    element.classList.remove('skeleton');
    element.style.animation = 'none';
  };

  // ==========================================
  // INITIALIZE
  // ==========================================
  document.addEventListener('DOMContentLoaded', function() {
    // Add loaded class for any CSS animations
    document.body.classList.add('initialized');
    
    // Remove preloader if exists
    const preloader = document.querySelector('.preloader');
    if (preloader) {
      preloader.style.opacity = '0';
      setTimeout(function() {
        preloader.remove();
      }, 300);
    }

    // Initialize tooltips (if using Bootstrap)
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });

})();