import Axios from "axios";

export const Zimbel_Script = () => {
    return{
        type_ahead(text){
            if(text.length < 3){
                return;
            }
            
            return (model) => Axios.get(`/api/${model}/search/?search=${text}`);
            
            
        },
        displayResults(data, previewElement, model){
            if(!data){
                return;
            }
            const list = [];
            data.forEach( item => {
                list.push(
                    `<li class="mb-5">
                        <input type="radio" name="${model}_id" id="${model}-${item.id}" value="${item.id}"/>
                        <label for="${model}-${item.id}"> ${item.first_name || item.title}</label>
                    </li>`
                );
            });
            
            previewElement.innerHTML = list.join('');
        },
        sendPaymentInfor(data){
            if( !data ){
                return;
            } 
            Axios.post('/paid', data ).then( resp =>{
                console.log( resp.data );
            })
        }
    };
    
}