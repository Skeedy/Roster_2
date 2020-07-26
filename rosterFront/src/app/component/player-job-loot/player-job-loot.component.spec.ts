import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PlayerJobLootComponent } from './player-job-loot.component';

describe('PlayerJobLootComponent', () => {
  let component: PlayerJobLootComponent;
  let fixture: ComponentFixture<PlayerJobLootComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PlayerJobLootComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PlayerJobLootComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
