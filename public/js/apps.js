function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
function downloadPDF() {
    const element = document.getElementById('printKartu');
    const scaleValue = window.devicePixelRatio > 1 ? 1.2 : 2; // Kurangi skala agar muat dalam satu halaman
    
    const opt = {
        margin: 10,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { 
            scale: scaleValue, // Kurangi skala jika perlu
            useCORS: true,
            backgroundColor: null,
            scrollX: 0, // Hindari scrolling horizontal
            scrollY: 0
        },
        jsPDF: { 
            unit: 'mm', 
            format: 'a4', // Bisa diganti dengan 'letter' jika perlu lebih besar
            orientation: 'portrait' 
        }
    };

    // Pastikan elemen ter-load penuh sebelum diekspor ke PDF
    setTimeout(() => {
        html2pdf().set(opt).from(element).toPdf().get('pdf').then(pdf => {
            const totalPages = pdf.internal.getNumberOfPages();
            for (let i = 1; i <= totalPages; i++) {
                pdf.setPage(i);
                pdf.setFontSize(10);
                // pdf.text('RSUD Brebes - https://sim.rsudbrebes.id/karir');
            }
            pdf.save();
        });
    }, 1500); // Tambahkan delay untuk memastikan semua elemen ter-render
}
