import { Pipe, PipeTransform } from '@angular/core';
import {Item} from "../class/item";


@Pipe({
  name: 'isCoffer'
})
export class IsCofferPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    if (value) {
      return value.filter( (item: Item) => {
        return item.isCoffer;
      });
    }
    return value;
  }
}
