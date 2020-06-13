import Axios from "axios";
import { media_modal } from "./templates/media-modal";
export const Media = () => {
    return {
        selected_media: [],
        attach_media: false,
        current_tab: 'new',
        media_loaded: false,
        selectedMediaElementClasses : "selected border px-4 py-2 border-green-500".split(' '),
        attach_element: "#featured-image",
        attachment_preview: '.preview-featured',
        upload(files, csrf){
            const formData = this.prepareFiles(files);
            return Axios.post('/admin/media', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN' : csrf
                }
            })
        },
        prepareFiles(files){
            if(!files || files.length < 1){
                return;
            }
            const formData = new FormData();
            for (const file of files) {
                formData.append('files[]', file );
            }
           
            return formData;
        },
        attachListener(triggerSelector, modalTargetSelector ){
            const media_box = document.querySelector(modalTargetSelector);
            document.querySelector(triggerSelector).addEventListener('click', (e) => {
                e.preventDefault();
                this.attach_media = e.target.getAttribute('data-attach');
                media_box.innerHTML = media_modal(this.attach_media);
                media_box.classList.remove('hidden');
                this.modal_loaded(modalTargetSelector, this.attach_media);
            });
            
            document.querySelectorAll('.preview-featured .selected span').forEach( closeElement => {
                closeElement.addEventListener('click', e => {
                    const attachment_id = e.target.getAttribute('data-mediaid');
                    this.removeAttachment(attachment_id, e.target);
                })
                //edit image
                closeElement.parentElement.addEventListener('click', this.editAttachment.bind(this), false);
            });
            
            
        },
        switch_tabs(){
            const active_tab = "rounded bg-gray-500 text-white".split(' ');
            document.querySelectorAll('.tab').forEach( tab =>{
                if(tab.classList.contains(this.current_tab)){
                    tab.classList.add(...active_tab);
                }else{
                    tab.classList.remove(...active_tab );
                }
            })
        },
        modal_loaded(modalTargetSelector, loadMedia=false){
            //make tab active
            this.switch_tabs();

            document.querySelector(`${modalTargetSelector} .close`).addEventListener('click', (e) => {
                e.preventDefault();
                document.querySelector(modalTargetSelector).classList.add('hidden');
                this.media_loaded = false;
                this.attach_media = false;
                this.current_tab  = 'new';
            });
            
            const preview_box = document.querySelector('.preview-uploaded-images');
            
            document.querySelector('#upload-image').addEventListener('change', (e) => {

                preview_box.insertAdjacentHTML('beforeend', `<i class="mt-10 icon icon-spinner"> Uploading... </i>`);

                const csrf = document.querySelector('[name=_token]');
                Media().upload(e.target.files, csrf.value).then(resp => {
                    
                    const list = resp.data.map( media => {
                    const url = `/${media.disk}/${media.directory}/${media.filename}.${media.extension}`;

                    const attachmentLink = `
                        <a href="${url}" class="${this.selectedMediaElementClasses}" data-mediaid="${media.id}" >
                            <img src="/${media.disk}/${media.directory}/${media.filename}.${media.extension}" alt="${media.filename}" />
                        </a>`;
                        this.selected_media.push(attachmentLink);
                        return `
                            <li class="w-1/3">
                                ${attachmentLink}
                            </li>
                        `;
                    });
                    const button_text = this.attach_media ? 'Insert' : 'Done';
                    const button_class = this.attach_media ? 'insert' : 'close';
                    const button_element = `<div class="mt-10 "> <a href="#" class="font-bold text-green-500 border px-4 py-2 border-green-500 rounded ${button_class}"> ${button_text} </a> </div>`;
                    preview_box.innerHTML = '';
                    preview_box.insertAdjacentHTML('beforeend', list.join(''));
                    preview_box.insertAdjacentHTML('afterend', button_element);
                    e.target.value = '';
                    
                    
                }).catch( err => {
                    console.log(err);
                })
            })
            if(loadMedia){
                document.querySelector(`${modalTargetSelector} .old`).addEventListener('click', this.load_media.bind(this));
                document.querySelector(`${modalTargetSelector} .new`).addEventListener('click', this.show_form.bind(this));
            }
        },
        show_form(target, e){
            this.current_tab = 'new';
            this.switch_tabs();
            document.querySelector('.new-media').classList.remove('hidden');
            document.querySelector('.library-box').classList.add('hidden');

        },
        load_media(){
            this.current_tab = 'old';
            this.switch_tabs();
            document.querySelector('.new-media').classList.add('hidden');
            
            const library_box = document.querySelector('.library-box');
            if( this.media_loaded ){
                library_box.classList.remove('hidden')
                return
            }
            library_box.insertAdjacentHTML('beforeend', "<i class='icon icon-spinner'> A moment... </i>");
            library_box.classList.add('pt-20');

            Axios.get('/admin/media/indexApi').then( resp =>{
                const list = resp.data.data.map(media => {
                    const url = `/${media.disk}/${media.directory}/${media.filename}.${media.extension}`;
                    return `
                    <div class="w-1/4">
                        <a href="#" data-mediaid="${media.id}" data-mediaurl="${url}" class="media-item block">
                            <img src="${url}" alt="${media.filename}"/>
                        </a>
                    </div>
                    `
                });
                const button = `<a href="#" class="font-bold inline-block mt-10 text-green-500 border px-4 py-2 border-green-500 rounded insert"> attach </a>`;
                library_box.innerHTML = '';
                library_box.classList.add('flex', 'content-justify', 'w-full');
                library_box.insertAdjacentHTML('beforeend', list.join(''));
                library_box.insertAdjacentHTML('afterend', button);
                
                this.media_loaded = true;
                this.library_loaded()
            }).catch( err => {
                console.log(err);
            })
        },
        library_loaded(){
            document.querySelectorAll('.media-item').forEach( media_element=> {
                
                media_element.addEventListener('click', this.selectMedia.bind(this), false);
                
            });
            const insert_button = document.querySelector('.library-box + .insert');
            
            insert_button.addEventListener('click', this.insert_attachment.bind(this))

        },
        selectMedia(e){
            e.preventDefault();
            
            //const classes = ['border', 'border-2', 'border-blue-500', 'p-3']
            if(e.target.parentNode.classList.contains('border')){
                _.remove(this.selected_media, (media_element)=>{
                    return media_element === e.target.parentNode
                });
                e.target.parentNode.classList.remove(...this.selectedMediaElementClasses);
                
            }else{
                e.target.parentNode.classList.add(...this.selectedMediaElementClasses);
                
                this.selected_media.push(e.target.parentNode);
            }
        },
        insert_attachment(){
            const preview_box = document.querySelector(this.attachment_preview)
            preview_box.classList.add('mb-8');
            const media_ids = this.get_media_ids(this.selected_media);
            preview_box.append(...this.selected_media);
            document.querySelector(this.attach_element).value = media_ids.join(',');
            //insertAdjacentHTML('beforeend', this.selected_media.join(''));
        },
        get_media_ids(elements){
            return elements.map( element => {
                element.classList.remove(...this.selectedMediaElementClasses);
                element.classList.add('w-1/2');
                return element.getAttribute('data-mediaid');
            })
        },
        removeAttachment(attachment_id, element){
            if( !attachment_id ){
                return;
            }
            const featured_input =  document.querySelector('#featured-image');
            let attachment_ids = featured_input.value;
            attachment_ids = attachment_ids.split(',').filter( id => id !== attachment_id );
            featured_input.value = attachment_ids;
            element.previousElementSibling.remove();
            element.remove();
        },
        editAttachment(event){
            const attachment_id = event.target.getAttribute('data-mediaid');
        }
    }
}