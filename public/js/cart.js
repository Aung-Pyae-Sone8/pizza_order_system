$(document).ready(function () {
    // when + button click
    $(".btn-plus").click(function () {
        $parentNode = $(this).parents("tr");
        $price = Number($parentNode.find("#price").html().replace("Ks", ""));
        $qty = Number($parentNode.find("#qty").val());

        $total = $price * $qty;
        $parentNode.find("#total").html($total + "Ks ");

        summaryCalculation();
    });

    // when - button click
    $(".btn-minus").click(function (event) {
        $parentNode = $(this).parents("tr");
        $price = Number($parentNode.find("#price").html().replace("Ks", ""));
        $qty = Number($parentNode.find("#qty").val());

        $total = $price * $qty;
        $parentNode.find("#total").html($total + "Ks ");

        summaryCalculation();
    });

    // summary calculation for order
    function summaryCalculation() {
        $totalPrice = 0;
        $("#dataTable tbody tr").each(function (index, row) {
            $totalPrice += Number(
                $(row).find("#total").text().replace("Ks", "")
            );
        });
        $("#subTotalPrice").html(`${$totalPrice} Ks`);
        $("#finalPrice").html(`${$totalPrice + 3000} Ks`);
    }
});
