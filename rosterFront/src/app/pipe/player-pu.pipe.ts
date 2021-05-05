import { Pipe, PipeTransform } from '@angular/core';
import {Player} from "../class/player";

@Pipe({
  name: 'playerPu'
})
export class PlayerPuPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    if (value) {
      return value.filter( (player: Player) => {
        return player.isPU;
      });
    }
    return value;
  }

}
