
document.addEventListener("DOMContentLoaded", function() {
    flatpickr("#birthday", {
        altInput: true,
        altFormat: "j F, Y",
        dateFormat: "Y-m-d",
        locale: {
            firstDayOfWeek: 1, // Monday
            weekdays: {
                shorthand: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"],
                longhand: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"]
            },
            months: {
                shorthand: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.",
                    "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
                ],
                longhand: [
                    "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                    "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
                ]
            }
        }
    });
});
