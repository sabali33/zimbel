import { Zimbel_Script } from "./main";
import  Zimbel_Payment  from "./google-payment";
import * as meta_form_template from './templates/meta-form';
import { WorldPay } from "./worldpay";
import { Rate } from "./rate";
import { media_modal } from "./templates/media-modal";
import { Media } from "./media";

window.onload = () => {
    const searchable = document.querySelectorAll('.searchable');
    searchable.forEach( field => {
        field.addEventListener('input', (e) =>{
            const model = e.target.getAttribute('data-model');
            if( !model ){
                return;
            }
            const targetElement = document.querySelector(`.suggested-${model}-list`);
            targetElement.classList.remove('hidden');
            let callback = Zimbel_Script().type_ahead(e.target.value);

            if( !callback ){
                return;
            }
            callback(model).then(resp =>{
                    if(resp.data && resp.data.length > 0){
                        Zimbel_Script().displayResults(resp.data,targetElement ,model );
                    }
                }).catch(err => console.log(err));
        
        })
    })
    /**
     * Add meta forms
     */

     const add_meta_button = document.querySelector('.add-meta-form');
     const form_box = document.querySelector('.meta-form-box');
     
     let meta_count = null;
     if(form_box){
        form_box.getAttribute('data-metacount'); 
     }
     
     let close_buttons = document.querySelectorAll('.meta-item .close');
     if( add_meta_button){
        add_meta_button.addEventListener('click', () => {
        meta_count++;
        form_box.insertAdjacentHTML('beforeend', meta_form_template.default().replace('%', meta_count).replace('%', meta_count ))
        
        close_buttons = document.querySelectorAll('.close');
        close_buttons.forEach( button => {
            button.addEventListener('click', e => {
                const meta_row = e.target.parentNode;
                meta_row.remove();
            })
        })
        });
        close_buttons.forEach(button => {
            button.addEventListener('click', e => {
                e.target.parentNode.remove()
            })
        })
     }
     
    if(document.querySelector('#gpay-box')){
        Zimbel_Payment().onGooglePayLoaded(); 
    }
    if( document.querySelector('#worldpay-section')){
        WorldPay().load();
    }
    if( document.querySelector('.user-rate')){
        Rate(document.querySelector('.user-rate')).listenToRate();
    }
    // media library interactions
    if(document.querySelector('.add-media')){
        Media().attachListener('.add-media', '.media-modal-box');
        
        
    }
}