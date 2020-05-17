import { Pipe, PipeTransform } from '@angular/core';
import {Job} from "../class/job";

@Pipe({
  name: 'meleedps'
})
export class MeleedpsPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    if (value) {
      return value.filter( (jobs: Job) => {
        return jobs.subrole === 'melee';
      });
    }
    return value;
  }

}
