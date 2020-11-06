export const CalculatePayment = (shopcart) => {
    let products = shopcart.products;
    let total = products.reduce((resutlTotal, product) => {
        return resutlTotal += product.price * product.quantity;
    }, 0)
    return total;
}