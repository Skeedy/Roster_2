import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {JobService} from "../../service/job.service";
import {Job} from "../../class/job";
import {Player} from "../../class/player";
import {animate, style, transition, trigger} from "@angular/animations";
import {RosterService} from "../../service/roster.service";
import {PlayerJob} from "../../class/player-job";

@Component({
  selector: 'app-jobs',
  templateUrl: './jobs.component.html',
  styleUrls: ['./jobs.component.scss'],
  animations: [
    trigger('jobs', [
      transition('void => *', [
        style({ transform: 'scale3d(.3, .3, .3)' }),
        animate(100)
      ]),
      transition('* => void', [
        animate(100, style({ transform: 'scale3d(.0, .0, .0)' }))
      ])
    ])
  ]
})
export class JobsComponent implements OnInit {
  private html: string;
  private isSet: boolean;
  @Input() closable = true;
  @Input() isSub: boolean;
  @Input() jobList: boolean;
  @Input() ddbId: number;
  @Input() jobOrder: number;
  @Input() player: Player;
  @Output() jobListChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  constructor(private jobServ: JobService,private rosterServ: RosterService) { }

  ngOnInit(): void {
  }
  checkJob(jobId){
    return !this.player.playerJobs.filter((playerJob: PlayerJob) => {
      return playerJob.job.id;
    }).some(( playerJob: PlayerJob) => {
      return playerJob.job.id === jobId;
    })
  }
  close() {
    this.jobList = false;
    this.jobListChange.emit(this.jobList);
    this.html = undefined;
  }
  patchJob(bool, job, player){
    this.rosterServ.patchJob(bool, job, player, this.ddbId, this.jobOrder).subscribe(data =>{
      this.rosterServ.getRosters();
      this.html = 'Changed succeeds !';
      console.log(this.html)
    },(err) => {
      console.log(err.error.response)
      this.html = err.error.response;
    })
  }

  delete(){
    this.rosterServ.deleteJob(this.ddbId).subscribe(_ =>
      this.rosterServ.getRosters())
  }
}
