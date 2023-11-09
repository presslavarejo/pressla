<script>
    function changeList(num) {
        if (num == 1) {
            $('.status').show()
            $('.localizacao').hide()
        } else if (num == 2) {
            $('.status').hide()
            $('.localizacao').show()
        }
    }
</script>