import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DeleteRosterComponent } from './delete-roster.component';

describe('DeleteRosterComponent', () => {
  let component: DeleteRosterComponent;
  let fixture: ComponentFixture<DeleteRosterComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DeleteRosterComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DeleteRosterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
