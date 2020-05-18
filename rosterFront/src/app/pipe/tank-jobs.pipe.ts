import { Pipe, PipeTransform } from '@angular/core';
import {Job} from "../class/job";

@Pipe({
  name: 'tankJobs'
})
export class TankJobsPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    if (value) {
      return value.filter( (jobs: Job) => {
        return jobs.role === 'TANK';
      });
    }
    return value;
  }
}
