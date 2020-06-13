export const media_modal = (attach = false) => {
    let template = `
    <div class="add-media-box container mx-auto bg-gray-100 p-10 relative mt-40">
        <span class="close icon icon-times absolute right-0 top-1 text-2xl p-2 text-red-500 cursor-pointer"></span>
        <div class="mb-5">
            <span class="new tab px-4 py-2 font-bold inline-block cursor-pointer"> Upload </span>
            %t
        </div>
        <hr>
        <div class="content">
            <div class="new-media p-12">
                <form action="/admin/media/create" method="post">
                    <label for="upload-image"> Upload file </label>
                    <input type="file" name="file" class="upload-image ml-5" id="upload-image" multiple="true" />
                    
                </form>
                <ul class="preview-uploaded-images mt-5"></ul>
            </div>
            %s
            
        </div>
    </div>
    `
    const attach_tab = '<span class="old tab ml-10 px-4 py-2 font-bold rounded inline-block cursor-pointer">Choose from library</span>';
    const libray_box = `
    <div class="library-box">
        
    </div>
    `;

    if( attach ){
        template = template.replace("%t",attach_tab ).replace('%s', libray_box);
    }
    template = template.replace("%t", '').replace('%s', '');
    return template ;
   
}