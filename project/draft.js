function toggleSection(sectionId) {
    var checkbox = document.getElementById(sectionId); // الحصول على الـ checkbox
    var content = document.getElementById("content" + sectionId.slice(-1)); // الحصول على القسم الخاص بـ Strategy
    var section = checkbox.parentElement; // القسم الرئيسي
    
    if (checkbox.checked) {
        // تفعيل الحقول إذا كان الـ checkbox مفعّل
        content.classList.add("active");
        section.classList.add("active");
    } else {
        // إلغاء تفعيل الحقول إذا كان الـ checkbox غير مفعّل
        content.classList.remove("active");
        section.classList.remove("active");
    }

    // تفعيل أو تعطيل زر الإرسال بناءً على ما إذا كان هناك اختيار مفعل أم لا
    toggleSubmitButton();
}

function toggleSubmitButton() {
    var checkboxes = document.querySelectorAll('.selectCheckbox');
    var submitButton = document.querySelector('button[type="submit"]');
    var isAnyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

    submitButton.disabled = !isAnyChecked; // يتم تمكين زر الإرسال فقط إذا كان هناك مربع اختيار واحد على الأقل مفعّل
}

function validateForm() {
    var checkboxes = document.querySelectorAll('.selectCheckbox');
    var isAnyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

    if (!isAnyChecked) {
        alert("Please select at least one section.");
        return false; // منع إرسال النموذج إذا لم يكن هناك أقسام مفعلة
    }
    return true; // السماح بإرسال النموذج
}

// تحديث حالة زر الإرسال عند تحميل الصفحة لأول مرة
document.addEventListener('DOMContentLoaded', function() {
    toggleSubmitButton(); // للتحقق من حالة مربعات الاختيار عند تحميل الصفحة
});