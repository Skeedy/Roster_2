import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'imgpath'
})
export class ImgPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    return 'http://api.roster.fr/' + value;
  }

}
