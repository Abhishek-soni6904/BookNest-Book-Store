function openModal(modalId) {
  modalId.style.display = "flex";
}
function closeModal(modalId) {
  modalId.style.display = "none";
}
function printOrder(orderId) {
  const content = document.querySelector(`#order-${orderId}`).innerHTML;
  const printWindow = window.open('', '', 'height=600,width=800');
  
  printWindow.document.write(`
      <html>
          <head>
              <title>Order #${orderId}</title>
              <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
              <link rel="stylesheet" href="css/nav&footer.css">
              <link rel="stylesheet" href="css/index.css">
              <style>
                  body { padding: 20px; }
                  .order-card { max-width: 800px; margin: 0 auto; }
                  .action-buttons { display: none; }
              </style>
          </head>
          <body>
              <div class="order-card">
                  ${content}
              </div>
          </body>
      </html>
  `);
  
  printWindow.document.close();
  printWindow.focus();
  
  // Wait for resources to load
  setTimeout(() => {
      printWindow.print();
      printWindow.close();
  }, 250);
}
