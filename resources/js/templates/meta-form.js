export default () => {
    return  `
    <div class="meta-item flex items-center mb-5">
        <div class="w-1/2">
            <label for="meta" class="mb-3 inline-block" > Meta Key </label>
            <input name="meta[%][]" class="w-full rounded px-5 py-3 rounded"/>
        </div>
        <div class="w-1/2 ml-5">
            <label for="value" class="mb-3 inline-block" > Meta Value </label>
            <input name="meta[%][]" class="w-full rounded px-5 py-3 rounded"/>
        </div>
        <span class="icon icon-times text-red-500 self-end w-20 text-3xl close cursor-pointer"> </span>
    </div>
    
    `
}