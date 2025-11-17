<?php
$tooltipText = "Our HTML editor updates the webview automatically in real-time as you write code.";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <style>
    .tooltip {
      position: relative;
      display: inline-block;
      cursor: pointer;
    }

    .tooltip-text {
      visibility: hidden;
      opacity: 0;
      width: 250px;
      background: rgba(0, 0, 0, 0.85);
      color: #fff;
      padding: 8px 12px;
      border-radius: 6px;
      position: absolute;
      left: 0;
      top: 120%;
      transition: opacity 0.3s ease;
      pointer-events: none;
      z-index: 999;
    }

    .tooltip:hover .tooltip-text {
      visibility: visible;
      opacity: 1;
    }
  </style>

</head>

<body>

  <p class="tooltip">
    hello..,
    <span class="tooltip-text">
      <?= $tooltipText; ?>
    </span>
  </p>

</body>

</html>