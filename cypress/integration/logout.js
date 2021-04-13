describe('Logout test', () => {
    beforeEach(() => {
        cy.viewport(1280, 720);
        cy.login();
    });
    it('Logout', () => {
        cy.visit("/");
        cy.get('h1').should('contain', 'Hello');
        cy.get('[data-test=logout]').click();
    })
})