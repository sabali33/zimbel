
export const Rate = (element) => {
  const span = document.createElement('span');
  span.style.color = "#161616";
  element.style.width = '200px';
  element.style.position = 'relative';
  element.append(span);
  return {
    px : 0,
    py : 0,
    boxWidth: 0,
    rate : 0,
    listenToRate(){
      element.addEventListener('mousemove', this.trackMouse.bind(this));
      element.addEventListener('mouseleave', this.reset.bind(this));
      element.addEventListener('click', () => {
        element.removeEventListener('mousemove', this.trackMouse );
        element.removeEventListener('mouseleave', this.reset);
      })
    },
    trackMouse(e){
      this.boxWidth = element.clientWidth;
      const unit = this.boxWidth/5;
      this.px = e.pageX - element.offsetLeft;
      this.py  = e.pageY;
      element.style.background = `linear-gradient(to right, green 0%, green ${this.px/2}%, #fff 0% ${this.px/2}%)`;
      this.rate  = (this.px/unit).toFixed(1)
      span.innerHTML = this.rate;
      span.style.position = 'absolute';
      span.style.left = `${this.px}px`;
      
    },
    reset(e){
      this.px = 0;
      this.py = 0;
      element.style.background = 'gray';
      this.rate = 0;
      span.innerHTML  = 0;
      span.style.left = 0;
    }
  }
}