
document.addEventListener('DOMContentLoaded', function () {
  // Get current URL
  let currentUrl = window.location.href;

  // Find all nav links
  document.querySelectorAll('.sidebar .nav-link').forEach(function (link) {
      // Match URL
      if (link.href && currentUrl.startsWith(link.href)) {
        // Add active class to <a>
        link.classList.add('active');

        // Expand parent menu if exists
        let collapseDiv = link.closest('.collapse');
        if (collapseDiv) {
            collapseDiv.classList.add('show');

            // Also add active class to parent toggle link
            let parentToggle = collapseDiv.previousElementSibling;
            if (parentToggle) {
                parentToggle.classList.add('active');
                parentToggle.setAttribute('aria-expanded', 'true');
            }
        }

        // Highlight nav-item as active
        let navItem = link.closest('.nav-item');
        if (navItem) {
            navItem.classList.add('active');
        }
      }
  });
});