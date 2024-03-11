class IdleTimerDisplay {
  constructor(displayCallback) {
    this.elapsedTime = 0; // Time in seconds
    this.displayCallback = displayCallback; // Callback to display time
  }

  // Method to update and display the time
  step() {
    this.elapsedTime++;
    this.display();
  }

  // Method to reset the timer
  reset() {
    this.elapsedTime = 0;
    this.display();
  }

  // Method to display the time
  display() {
    let seconds = this.elapsedTime % 60;
    let minutes = Math.floor(this.elapsedTime / 60) % 60;
    let hours = Math.floor(this.elapsedTime / 3600) % 24;
    let days = Math.floor(this.elapsedTime / 86400);

    let displayStr = `${seconds}s`;
    if (this.elapsedTime >= 60) displayStr = `${minutes}m ${displayStr}`;
    if (this.elapsedTime >= 3600) displayStr = `${hours}h ${displayStr}`;
    if (this.elapsedTime >= 86400) displayStr = `${days}d ${displayStr}`;

    this.displayCallback(displayStr);
  }
}

class IdleTimer {
  constructor({ timeout, onTimeout, onExpired }) {
    this.timeout = timeout;
    this.onTimeout = onTimeout;

    const expiredTime = parseInt(localStorage.getItem("_expiredTime") || 0, 10);
    if (expiredTime > 0 && expiredTime < Date.now()) {
      this.cleanUp();
      onExpired();
      return;
    }

    // this.idleTimerDisplayElement = document.getElementById('idle-timer-display');

    this.idleTimerDisplay = new IdleTimerDisplay((timeStr) => {
      setTimeout(() => {
        const displayElement = document.getElementById('idle-timer-display');
        if (displayElement) {
          displayElement.innerHTML = timeStr;
          // $('#idle-timer-display').text(timeStr);
        } else {
          console.error('Display element not found');
        }
      }, 0); // A delay of 0 milliseconds effectively defers the execution until the stack is clear
    });

    this.eventHandler = this.updateExpiredTime.bind(this);
    this.tracker();
    this.startInterval();
  }

  startInterval() {
    this.updateExpiredTime();

    this.interval = setInterval(() => {
      const expiredTime = parseInt(
        localStorage.getItem("_expiredTime") || 0,
        10
      );

      if (expiredTime < Date.now()) {
        if (this.onTimeout) {
          this.cleanUp();
          this.onTimeout();
        }
      };

      this.idleTimerDisplay.step();
    }, 1000);
  }

  updateExpiredTime() {
    if (this.timeoutTracker) {
      clearTimeout(this.timeoutTracker);
    }
    this.timeoutTracker = setTimeout(() => {
      localStorage.setItem("_expiredTime", Date.now() + this.timeout * 1000);
      this.idleTimerDisplay.reset();
    }, 300);
  }

  tracker() {
    window.addEventListener("mousemove", this.eventHandler);
    window.addEventListener("scroll", this.eventHandler);
    window.addEventListener("keydown", this.eventHandler);
  }

  cleanUp() {
    localStorage.removeItem("_expiredTime");
    clearInterval(this.interval);
    window.removeEventListener("mousemove", this.eventHandler);
    window.removeEventListener("scroll", this.eventHandler);
    window.removeEventListener("keydown", this.eventHandler);
  }
}

console.log("Idle session will expire after <?= $idle_timeout; ?> ");

const logoutTimer = new IdleTimer({
  timeout: <?= $idle_timeout; ?>,
  onTimeout: () => {
    location.href='<?= $logout_url; ?>';
  },
  onExpired: () => {
    location.href='<?= $logout_url; ?>';
  }
});
