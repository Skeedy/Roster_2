import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import { Roster } from 'src/app/class/roster';
import {Router} from "@angular/router";
import {RosterService} from "../../service/roster.service";
import {animate, style, transition, trigger} from "@angular/animations";

@Component({
  selector: 'app-delete-roster',
  templateUrl: './delete-roster.component.html',
  styleUrls: ['./delete-roster.component.scss'],
  animations: [
    trigger('deleteShow', [
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
export class DeleteRosterComponent implements OnInit {
  @Input() roster : Roster;
  @Input() deleteShow: boolean;
  @Output() deleteShowChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  constructor(private router : Router,
              private rosterServ : RosterService) { }

  ngOnInit(): void {
  }
  delete(){
    this.rosterServ.deleteRoster().subscribe(()=> {
    this.rosterServ.logout();
    this.router.navigate(['/'])
      }, ()=>{

      }
    );
  }

  close(){
    this.deleteShowChange.emit(this.deleteShow = false);
  }
}
