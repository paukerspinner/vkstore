// import { result } from "lodash";

export const FormatOrderStatus = (statusNum) => {
    // 'ORDER_APPLY' => 0,
    // 'ORDER_ACCEPT' => 1,
    // 'ORDER_SHIPPING' => 2,
    // 'ORDER_COMPLETE' => 3,
    // 'ORDER_FAIIL' => -1
    switch (statusNum) {
        case 0:
            return 'Đang chờ xử lý';
        case 1:
            return 'Đã được tiếp nhận';
        case 2:
            return 'Đang vận chuyển';
        case 3:
            return 'Hoàn thành';
        case -1:
            return 'Đã hủy';
    }
}

export const GetNextActionOrder = (statusNum) => {
    switch (statusNum) {
        case 0:
            return 'Tiếp nhận';
        case 1:
            return 'Vận chuyển';
        case 2:
            return 'Hoàn thành';
    }
}

export const FormatCurrency = (currency) => {
    currency = '' + currency;
    let result = '';
    while (currency.length > 0) {
        result = currency.match(/\d{1,3}$/) + result;
        currency = currency.substring(0, currency.length-3);
        if (currency.length > 0) {
            result = ',' + result;
        }
    }
    return result;
}

export const FormatAddress = (...addressUnit) => {
    return addressUnit.join(', ');
}

export const FormatDate = (timestamp) => {
    let time = new Date(timestamp);
    let date = time.getDate();
    let mon = time.getMonth();
    let year = time.getFullYear();
    return `${date}/${mon}/${year}`;
}