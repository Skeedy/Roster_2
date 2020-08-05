import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { UpgradeSelectJobComponent } from './upgrade-select-job.component';

describe('UpgradeSelectJobComponent', () => {
  let component: UpgradeSelectJobComponent;
  let fixture: ComponentFixture<UpgradeSelectJobComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ UpgradeSelectJobComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(UpgradeSelectJobComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
