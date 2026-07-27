<script>
// Disable right click (context menu)
document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
});

// Disable key combinations like F12, Ctrl+Shift+I, Ctrl+U
document.addEventListener('keydown', function(e) {
  if (
    e.key === 'F12' ||
    (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) ||
    (e.ctrlKey && e.key === 'U')
  ) {
    e.preventDefault();
  }
});

// Prevent video download
document.querySelectorAll("video").forEach(function(video) {
  video.setAttribute("controlsList", "nodownload");
  video.addEventListener("contextmenu", function(e) {
    e.preventDefault();
  });
});
</script>
