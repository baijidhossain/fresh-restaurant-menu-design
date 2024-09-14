import QRCode from 'qrcode-svg';

window.generateQRCode = function (event) {
    event.preventDefault();
    event.stopPropagation();

    const form = event.target;
    const formData = new FormData(form);

    // Convert FormData to an object
    const data = {};
    formData.forEach((value, key) => {
        if (data[key]) {
            // Handle array fields (e.g., notes[])
            if (!Array.isArray(data[key])) {
                data[key] = [data[key]];
            }
            data[key].push(value);
        } else {
            data[key] = value;
        }
    });

    const contact = {
        firstname: data.firstname,
        lastname: data.lastname,
        organization: data.organization,
        position: data.position,
        phoneWork: data.phone_work,
        phonePrivate: data.phone_private,
        faxWork: data.fax_work,
        email: data.email,
        website: data.website,
        street: data.street,
        zipcode: data.zipcode,
        city: data.city,
        state: data.state,
        country: data.country,
        notes: data['notes[]'] || [],
    };

    const vCard = generateVCard(contact);

    const qrcodeCanvas = document.getElementById('qrcode-canvas');

    const qrcode = new QRCode({
        content: vCard,
        padding: 4,
        width: 256,
        height: 256,
        color: '#000000',
        background: '#ffffff',
        ecl: 'M',
        join: true, // Join modules into a single SVG path
    });

    const svg = qrcode.svg();

    qrcodeCanvas.innerHTML = svg;

    const downloadLink = document.createElement('a');
    downloadLink.setAttribute('href', 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svg));
    downloadLink.setAttribute('download', 'qrcode.svg');
    downloadLink.style.display = 'none';
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
};

window.generateVCard = function (contact) {

    // Ensure `notes` is always an array
    const notes = Array.isArray(contact.notes) ? contact.notes : [contact.notes].filter(Boolean);

    let vCard = `BEGIN:VCARD
VERSION:3.0
N:${contact.firstname} ${contact.lastname}
FN:${contact.firstname} ${contact.lastname}
ORG:${contact.organization}
TITLE:${contact.position}
TEL;TYPE=WORK:${contact.phoneWork}
TEL;TYPE=CELL:${contact.phonePrivate}
TEL;TYPE=FAX:${contact.faxWork}
EMAIL:${contact.email}
URL:${contact.website}
ADR:${contact.street};
POSTAL:${contact.zipcode} ${contact.city} ${contact.state} ${contact.country}
`;

    // Append notes if available
    notes.forEach((note, index) => {
        vCard += `NOTE:${note}
`;
    });

    vCard += `END:VCARD`;

    return vCard;
};

window.addNote = function () {
    const notesContainer = document.getElementById('notes-container');
    const noteItem = document.createElement('div');
    noteItem.className = 'note-item flex items-center mb-2';
    noteItem.innerHTML = `
        <input
                                    class="w-full px-3 py-2 text-gray-700 bg-gray-100 rounded-md border border-stroke focus-visible:outline-none mr-2"
                                    type="text" name="notes[]" placeholder="Enter a note">
                                <button type="button" class="px-3 py-3 text-white bg-red-400 rounded-md"
                                    onclick="removeNote(this)">
                                    <i class="fa-light fa-trash"></i>
                                </button>
    `;
    notesContainer.appendChild(noteItem);
};

window.removeNote = function (button) {
    const notesContainer = document.getElementById('notes-container');
    notesContainer.removeChild(button.parentElement);
};
