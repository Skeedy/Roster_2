import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {JobService} from "../../service/job.service";
import {Job} from "../../class/job";

@Component({
  selector: 'app-jobs',
  templateUrl: './jobs.component.html',
  styleUrls: ['./jobs.component.scss']
})
export class JobsComponent implements OnInit {
@Input() closable = true;
@Input() jobList: boolean;
@Output() visibleChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  constructor(private jobServ: JobService) { }

  ngOnInit(): void {
  }
  close() {
    this.jobList = false;
    this.visibleChange.emit(this.jobList);
  }
}
