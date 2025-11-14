const selectPais = document.getElementById("paises");
const contenedor  = document.getElementById("conPaises");
const botonGenerarPdf = document.getElementById("btnPDF");
const botonCerrarSession = document.getElementById("btnCerrar");

let dataUniPdf = null;

selectPais.addEventListener('change', async (e) => {
    e.preventDefault();
    const paisSelec =  selectPais.value

    try{
        const response = await fetch(`http://universities.hipolabs.com/search?country=${paisSelec}`)
        const data = await response.json();

        contenedor.innerHTML = ""

        if(data.length === 0){
             contenedor.innerHTML = "<p> No se encontraron universidades </p>";
             return;
        }

        dataUniPdf = data;

        data.forEach(elemt => {
            const card = document.createElement('div');
            card.classList.add("tarjeta-uni");

            card.innerHTML = `
                <h3>${elemt.name}</h3>
                <p><strong>País:</strong> ${elemt.country}</p>
                ${elemt.domains
                    .map(dom => `<p><strong>Dominio:</strong> ${dom}</p>`)
                    .join('')}
                ${elemt.web_pages
                    .map(we => `<a href="${we}" target="_blank">Visitar página ${we}</a>`)
                    .join('')} 
            `;

            contenedor.appendChild(card);
        });
    } catch (error) {
        console.error('Error en la petición:', error);
    }
    
})


botonGenerarPdf.addEventListener('click', async (e) => {
    e.preventDefault();

    if (!dataUniPdf || dataUniPdf.length === 0) {
        alert("Primero cargue universidades seleccionando un país.");
        return;
    }

    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF();
    let y = 10;
    
    pdf.setFontSize(16);
    pdf.text(`Listado de universidades de ${selectPais.value}`, 10, y);
    y += 10;

    pdf.setFontSize(12);
    
    dataUniPdf.forEach((uni, index) => {
        pdf.text(`${index + 1}. ${uni.name}`, 10, y);
        y += 7;
        pdf.text(`País: ${uni.country}`, 10, y);
        y += 7;

        uni.domains.forEach((d) => {
            pdf.text(`Dominio: ${d}`, 10, y);
            y += 10;
        })

        uni.web_pages.forEach((w) => {
            pdf.text(`Página Web: ${w}`, 10, y);
            y += 10;
        })

        if (y > 270) {
            pdf.addPage();
            y = 10;
        }
    });

    const pdfBlob = pdf.output("blob");
    const formData = new FormData();
    formData.append("archivo_pdf", pdfBlob, "archivo.pdf");
    formData.append("pais", selectPais.value);

    const response = await fetch("http://localhost:8080/api/save_pdf", {
        method: "POST",
        body: formData
    });

    const data = await response.json();

    if (data.success) {
        alert("exitoso")
    } else {
        alert('Error: ' + data.error);
    }
});

botonCerrarSession.addEventListener('click', async (e) => {
    e.preventDefault()

    const response = await fetch("http://localhost:8080/singin/logout")

    const data = await response.json()

    if(data.succes){
        window.location.href = "/"
    } else {
        console.log("no se pudo cerrar cession")
    }

});

document.addEventListener("DOMContentLoaded", () => {
    
    selectPais.dispatchEvent(new Event("change"));
});

selectPais.addEventListener('change',  async (e) => {
    e.preventDefault();
    const paisSelec =  selectPais.value

    try{
        const response = await fetch(`http://universities.hipolabs.com/search?country=${paisSelec}`)
        const data = await response.json();

        contenedor.innerHTML = ""

        if(data.length === 0){
             contenedor.innerHTML = "<p> No se encontraron universidades </p>";
             return;
        }

        dataUniPdf = data;

        data.forEach(elemt => {
            const card = document.createElement('div');
            card.classList.add("tarjeta-uni");

            card.innerHTML = `
                <h3>${elemt.name}</h3>
                <p><strong>País:</strong> ${elemt.country}</p>
                ${elemt.domains
                    .map(dom => `<p><strong>Dominio:</strong> ${dom}</p>`)
                    .join('')}
                ${elemt.web_pages
                    .map(we => `<a href="${we}" target="_blank">Visitar página ${we}</a>`)
                    .join('')} 
            `;

            contenedor.appendChild(card);
        });
    } catch (error) {

    }
    
})