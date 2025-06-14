<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body>
    <h1>Processing Payment...</h1>
    <script type="text/javascript">
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                alert("Pembayaran sukses!");
                console.log(result);
            },
            onPending: function(result){
                alert("Pembayaran masih pending");
                console.log(result);
            },
            onError: function(result){
                alert("Pembayaran gagal!");
                console.log(result);
            },
            onClose: function(){
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    </script>
</body>
</html>
